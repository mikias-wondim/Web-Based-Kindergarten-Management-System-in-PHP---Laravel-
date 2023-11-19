@extends('layouts.app')

@section('content')

    @error('file')
    <div class="bg-transparent d-flex justify-content-center fixed-bottom mb-3 p-3 ">
        <div id="flash-message" class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        <script>
            setTimeout(function () {
                document.getElementById('flash-message').classList.add('collapse');
            }, 3000);
        </script>
    </div>
    @enderror

    <main>
        <div class="head-title">
            <div class="left">
                <h1 class="heading">Chat and Messages</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">Messages</a>
                    </li>
                </ul>
            </div>
        </div>
        <section id="messages">

            @php
                $profile =  $user->staff ? $user->staff: $user->profile;
            @endphp

            <div class="wrapper">
                <section class="chat-area">
                    <header>
                        <a href="/chat" class="back-icon"
                        ><i class='bx bx-left-arrow-alt'></i></a>
                        <img src="{{ asset('storage/'.$profile->profile_pic) }}" alt=""/>
                        <div class="details">
                            <span>{{ ucwords(strtolower($profile->first_name . ' ' . $profile->middle_name )) }}</span>
                            <p><small class="dark-text center pe-1">Online <i class='bx bxs-circle ps-1'
                                                                              style="font-size: 10px; color: #23f323"></i></small>
                            </p>
                        </div>
                    </header>
                    <div class="chat-box">

                    </div>
                    @php
                        $receiverId = $profile->user->id;
                    @endphp
                    <form id="file-form" action="/chat/message-file"
                          enctype="multipart/form-data"
                          method="POST">
                        @csrf

                        <input type="hidden" name="receiver" value="{{ $receiverId }}">
                        <input id="file" type="file" name="message_file" hidden=""
                               onchange="document.getElementById('file-form').submit()">
                    </form>
                    <form action="#" id="typing-area" class="typing-area" onsubmit="event.preventDefault()">
                        @csrf

                        <label for="file" class="center"
                               title="select file"
                               style="
                        width: 45px;
                        border-radius: 5px 0 0 5px;
                        "><i class='bx bx-file'></i></label>
                        <input
                            type="text"
                            class="incoming_id"
                            name="receiver"
                            value="{{ $receiverId }}"
                            hidden
                        />
                        <input
                            type="text"
                            name="message_text"
                            class="input-field"
                            placeholder="Type your message ..."
                            onkeyup="allowButton(event)"
                            autocomplete="off"
                        />
                        <button id="send-btn" onclick="sendMessage()"><i class='bx bxl-telegram'></i></button>
                    </form>
                </section>
            </div>
        </section>
    </main>
    <!-- MAIN -->

    <script>
        let scroll = false;

        const form = document.getElementById("typing-area");
        const receiver = form.querySelector(".incoming_id").value;
        const inputField = form.querySelector(".input-field");
        const sendBtn = form.querySelector("#send-btn");
        const chatBox = document.querySelector(".chat-box");

        inputField.focus();

        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function allowButton(event) {
            const sendBtn = document.getElementById('send-btn');

            if (event.target.value.length > 0)
                sendBtn.style.pointerEvents = 'visible';
            else
                sendBtn.style.pointerEvents = 'none';
        }

        function sendMessage() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/chat");
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        inputField.value = "";
                        scroll = false;
                    }
                }
            }
            let formData = new FormData(form);
            xhr.send(formData);
        }

        setInterval(() => {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "/chat/user/"+receiver, true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        if (data.length === 0) {
                            chatBox.innerHTML = '<div class="center">No Messages here...</div>';
                        } else {
                            chatBox.innerHTML = data;
                            if(!scroll) {
                                scrollToBottom();
                                scroll = true;
                            }
                        }
                    }
                }
            }
            xhr.send();
        }, 500);

        scrollToBottom();

    </script>

@endsection
