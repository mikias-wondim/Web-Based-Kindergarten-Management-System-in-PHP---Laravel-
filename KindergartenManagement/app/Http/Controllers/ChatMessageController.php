<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ChatMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chat-messages.index');
    }

    /**
     * Store a newly created text messages in storage.
     */
    public function store(Request $request): void
    {
        //
        $message = [
            'sender' => auth()->user()->id,
            'receiver' => $request->input('receiver'),
            'message_text' => $request->input('message_text'),
        ];

        $message = ChatMessage::create($message);
    }

    /**
     * Store a newly created file messages in storage.
     */
    public function storeFile()
    {
        $messageFile = \request()->file('message_file');

        if ($messageFile->isValid()) {
            $fileName = $messageFile->getClientOriginalName();
            $fileType = $messageFile->getMimeType();

            $message = [
                'sender' => auth()->user()->id,
                'receiver' => \request()->input('receiver'),
                'message_file' => \request('message_file')->store('message-files', 'public'),
                'file_type' => $fileType,
                'file_name' => $fileName,
            ];

            $message = ChatMessage::create($message);
        }

        return redirect()->back();
    }

    /**
     * Display the specified chat.
     */
    public function show($chat)
    {
        $user = User::findOrFail($chat);
        return view('chat-messages.show', compact('user'));
    }

    /**
     * Returns all chats with selected users from storage.
     */
    public function getChat($user): string
    {
        $receiver = $user;
        $sender = auth()->user()->id;

        $receiverUser = User::find($user);

        if ($receiverUser->unique_name == 'admin') {
            $profilePicture = asset('image/No-profile.png');
        } elseif ($receiverUser->staff) {
            $profilePicture = asset('storage/' . $receiverUser->staff->profile_pic);
        } elseif ($receiverUser->profile) {
            $profilePicture = asset('storage/' . $receiverUser->profile->profile_pic);
        }

        $messages = ChatMessage::where(function ($query) use ($receiver, $sender) {
            $query->where('sender', $sender)->where('receiver', $receiver);
            $query->orWhere('sender', $receiver)->where('receiver', $sender);
        })->orderBy('created_at', 'asc')->get();

        $response = '';

        foreach ($messages as $message) {
            if ($message['message_file']) {
                $fileType = $message['file_type'];
                $filePath = asset('storage/' . $message['message_file']);
                if ($fileType == 'image/jpeg' || $fileType == 'image/gif' || $fileType == 'image/svg' || $fileType == 'image/png') {
                    if ($message['sender'] == $sender) {
                        $response .= "<div class='chat outgoing'>
                            <div class='details'>
                                <div class='file-msg'>
                                    <a href=" . $filePath . " target='_blank'>
                                        <img class='img-file' src=" . $filePath . "
                                             title='view image'
                                             alt='Reload to See Image'></a>
                                </div>
                            </div>
                        </div>";
                    } else {
                        $response .= "<div class='chat incoming'>
                            <img src=" . $profilePicture . " alt=''>
                            <div class='details'>
                                <div class='file-msg'>
                                    <a href=" . $filePath . " target='_blank'>
                                        <img class='img-file' src=" . $filePath . "
                                             title='view image'
                                             alt='Reload to See Image'></a>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    $fileName = $message['file_name'];
                    if ($message['sender'] == $sender) {
                        $response .= "<div class='chat outgoing'>
                            <div class='details'>
                                <p class='file-format center'>
                                    <a href= message/download/file/$filePath >
                                        <i class='center px-2 bx bx-down-arrow-circle'
                                           title='download file'
                                           style='font-size: 25px'></i>
                                    </a>
                                    $fileName
                                </p>

                            </div>
                        </div>";
                    } else {
                        $response .= "<div class='chat incoming'>
                            <img src=" . $profilePicture . " alt=''>
                            <div class='details'>
                                <p class='file-format center'>
                                    <a href= message/download/file/$fileName >
                                        <i class='center px-2 bx bx-down-arrow-circle'
                                           title='download file'
                                           style='font-size: 25px'></i>
                                    </a>
                                    $fileName
                                </p>

                            </div>
                        </div>";
                    }
                }

            } else {
                if ($message['sender'] == $receiver) {
                    $response .= "
                <div class='chat incoming'>
                            <img src=" . $profilePicture . " alt=''>
                            <div class='details'>
                                <p> " . $message['message_text'] . " </p>
                            </div>
                        </div>
              ";
                } else {
                    $response .= "
                <div class='chat outgoing'>
                            <div class='details'>
                                <p> " . $message['message_text'] . " </p>
                            </div>
                        </div>
              ";
                }
            }
            if ($message['receiver'] === $sender) {
                $message['viewed'] = 1;
            }

            $message->update();
        }
        return $response;
    }

    /**
     * Return all users that has chatted with the user
     */
    public function getUsers($selectedRole): string
    {
        $currentUser = auth()->user();
        $users = User::all()->except($currentUser->id);

        $lastMessages = [];
        foreach ($users as $user) {
            $lastMessage = self::getLastMessage($user->id, $currentUser->id);
            if ($lastMessage->toArray()) {
                $lastMessages[] = $lastMessage[0];
            }
        }

        usort($lastMessages, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        $response = '';

        foreach ($lastMessages as $lastMessage) {
            $incomingUser = $lastMessage->sender == $currentUser->id ? $lastMessage->receiver :
                $lastMessage->sender;
            $incomingUser = User::find($incomingUser);
            $incomingProfile = $incomingUser->staff ?? $incomingUser->profile;

            $userId = $incomingUser->id;
            $fullName = ucwords(strtolower($incomingProfile->first_name . ' ' . $incomingProfile->middle_name));
            $role = strtolower($incomingUser->role);
            $profilePicture = asset('storage/' . $incomingProfile->profile_pic);
            $you = ($lastMessage['sender'] == $currentUser->id) ? 'You: ' : '';
            $file = $lastMessage['message_file'] ? ' File ' . $lastMessage['file_type'] : '';
            if ($lastMessage['message_text'])
                $msg = str_split($lastMessage['message_text'], 30)[0] . ((count(str_split($lastMessage['message_text'], 20)) > 1) ? '...' : '');
            else $msg = '';
            $newMessage = (($newMsgCount = self::countNewMessages($incomingUser->id, $currentUser->id)) > 0) ?
                "<div class='new-msg center bg-primary px-2 rounded-circle' >
                    <span class='num text-white'> $newMsgCount </span>
                </div>" : '';

            if ($selectedRole == 'all' || $selectedRole == $role) {
                $response .= "
                <li class='$role'>
                    <a href='/chat/$userId' class= 'position-relative'>
                        <div class= 'content'>
                            <img src= '$profilePicture '
                                   height='50px'
                                 alt= ' '>
                            <div class= 'details '>
                                <span
                                    class= 'dark-text '>$fullName</span>
                                -
                                <small id= 'role '
                                       class= 'orange-text '>$role</small>
                                    <p>
                                       $you
                                       $file
                                       $msg
                                    </p>
                            </div>
                        </div>
                        <div class= 'd-flex position-absolute ' style= ' right: 5px; top: 50%; transform: translateY(-50%)'>
                            <div class= 'status-dot  '>
                                <i class='bx bxs-circle mx-2'
                                   style= 'font-size: 10px; color: #23f323 '></i>

                            </div>
                            $newMessage
                        </div>
                    </a>
            </li> ";
            }
        }
        return $response;
    }


    public function search(): string
    {
        $searchTerm = \request()->input('search-name');
        $searchRole = \request()->input('search-role');

        $response = '';

        $currentUser = auth()->user();
        $allUsers = User::all()->except($currentUser->id);

        foreach ($allUsers as $user) {
            $profile = $user->staff ?? $user->profile;

            $role = match(strtolower($profile->role)){
                    'teacher' => 'teacher',
                    'child' => 'child',
                    'reception' => 'reception',
                    'accountant' => 'accountant',
                    'school director' => 'director',
                    'system admin' => 'admin',
            };

            if ($searchRole == 'all' || $searchRole == $role) {
                if (str_contains(strtolower($profile->first_name . $profile->first_name), strtolower($searchTerm))) {

                    $userId = $user->id;
                    $fullName = ucwords(strtolower($profile->first_name . ' ' . $profile->middle_name));
                    $role = strtolower($profile->role);
                    $profilePicture = asset('storage/' . $profile->profile_pic);

                    $response .= "
                <li class='$role'>
                    <a href='/chat/$userId' class= 'position-relative'>
                        <div class= 'content'>
                            <img src= '$profilePicture '
                                   height='50px'
                                 alt= ' '>
                            <div class= 'details '>
                                <span
                                    class= 'dark-text '>$fullName</span>
                                    <p>
                                       $role
                                    </p>
                            </div>
                        </div>
                        <div class= 'd-flex position-absolute ' style= ' right: 5px; top: 50%; transform: translateY(-50%)'>
                            <div class= 'status-dot  '>
                                <i class='bx bxs-circle mx-2'
                                   style= 'font-size: 10px; color: #23f323 '></i>

                            </div>
                        </div>
                    </a>
            </li> ";
                }
            }
        }

        return $response;
    }

    public function download($fileName)
    {
        $filePath = public_path('storage\\' . $fileName);
        $dataType = explode('.', $fileName)[1];

        // Check if the file exists
        if (file_exists($filePath)) {
            $headers = [
                'Content-Type' => 'application/' . $dataType,
            ];

            return Response::download($filePath, $fileName, $headers);
        } else {
            abort(404, 'File not found');
        }
    }

    public static function getLastMessage($receiver, $sender)
    {
        return ChatMessage::where(function ($query) use ($receiver, $sender) {
            $query->where('sender', $sender)->where('receiver', $receiver);
            $query->orWhere('sender', $receiver)->where('receiver', $sender);
        })->latest()->limit(1)->get();
    }

    public static function countNewMessages($sender, $receiver): int
    {
        $newMessages = ChatMessage::where(function ($query) use ($receiver, $sender) {
            $query->where('sender', $sender)->where('receiver', $receiver)->where('viewed', 0);
        })->get();

        return count($newMessages);
    }
}
