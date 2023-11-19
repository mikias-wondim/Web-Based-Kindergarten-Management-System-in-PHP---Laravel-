import './bootstrap';

const nextQuarterBtn = document.getElementById('next-quarter-btn');
const prevQuarterBtn = document.getElementById('prev-quarter-btn');
nextQuarterBtn.addEventListener('click',  (event)=>changeQuarter(event));
prevQuarterBtn.addEventListener('click',  (event)=>changeQuarter(event));

const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
    const li = item.parentElement;

    item.addEventListener('click', function () {
        allSideMenu.forEach(i=> {
            i.parentElement.classList.remove('active');
        })
        li.classList.add('active');
    })
});


const addAbsenceBtn = document.getElementById('addAbsenceBtn');
addAbsenceBtn.addEventListener('click', (event)=>addAbsenceRecord());
let attendanceFormCounter = 0;
function addAbsenceRow(event){
    let absenceTable = document.getElementById('absenceTable');
    let profileId = document.getElementById('profile-id');

    absenceTable.innerHTML = `      <form method="POST" action="/attendance/${profileId.value}/create" id="attendanceform${++attendanceFormCounter}" >
                                        <tr id="additional">
                                            <td><input type="date" name="date" class="text-input form-control" required autofocus></td>
                                            <td><input type="text" name="reason" class="text-input form-control " required autofocus></td>
                                            <td>
                                                <select type="text" name="permission" class="text-input form-control" required>
                                                    <option selected disabled> Permission</option>
                                                    <option value="Yes"> Yes</option>
                                                    <option value="No"> No</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="remark" class="text-input form-control " required>
                                            <td class="d-flex justify-content-between">
                                                <button
                                                    type="submit"
                                                    onclick="
                                                        console.log(event.target.parentNode.parentElement.parentElement)

                                                    "
                                                    class="d-flex btn btn-success mb-1 align-items-center">
                                                    <i class='bx bx-save' ></i> <span class="show-detail">Save</span>
                                                </button>
                                                <div class="d-flex btn btn-danger mb-1 align-items-center">
                                                    <i class='bx bx-trash'></i><span class="show-detail">Remove</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </form>
                               ` + absenceTable.innerHTML;
}

function addAbsenceRecord(){
    let attendanceForm = document.getElementById('additional');
    attendanceForm.classList.remove('collapse');
}

const addSubjectBtn = document.getElementById('addSubject');




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

// menuBar.addEventListener('click', function () {
//     sidebar.classList.toggle('hide');
// })

const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if(window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if(searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
})


if(window.innerWidth < 768) {
    sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
    if(this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
    if(this.checked) {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
    }
})



function changeQuarter(event){

    const quarters = document.getElementsByClassName('quarter');
    const quarterNumber = document.getElementById('quarter-number');

    let currentQuarter = Array.from(quarters).filter(quarter => {
        return !quarter.classList.contains('collapse');
    });

    let quarter = currentQuarter[0].classList[1];
    let num = quarter; let changedQuarter;

    if (quarter !== '1' && event.target.id === 'prev') {
        num = Number(quarter) - 1;
    }
    else if (quarter !== '4' && event.target.id === 'next') {
        num = Number(quarter) + 1;
    }

    currentQuarter[0].className += " collapse";

    changedQuarter = Array.from(quarters)
        .filter(quarter => {return quarter.classList.contains(`${num}`)})[0];

    changedQuarter.classList.remove('collapse');

    quarterNumber.innerText = `Quarter ${num}`;
}


