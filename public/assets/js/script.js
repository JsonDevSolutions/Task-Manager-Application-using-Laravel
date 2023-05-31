// Fetch tasks list in first load
fetchTask();

// Triggers when save button is clicked, Both works for saving and updating
$("#btn_save").click(function() {
    $.post($("#save_update_frm").attr("action"), $("#save_update_frm").serialize(), function() {
        // Check if action is for update or not
        if ($("#method").val() == "PUT") {
            toast_message('success', 'Successfully Updated.');
            $("#close_modal").click();
        } else {
            $("#alerts").append(`<div class="alert alert-success bg-success text-white p-1" role="alert">Task Successfully saved!</div>`);
        }
        clearInputValues();
    })
    .fail(function(errors) { 
        // Display Error messages
        const error_messages = errors.responseJSON;

        for (const key in error_messages) {
            $("#alerts").append(`<div class="alert alert-danger bg-danger text-white p-1" role="alert">${error_messages[key]}</div>`);
        }
    });

    fetchTask();
    removeAlertMessages();
    return false;
});

// Clear input values when modal is closed
$("#close_modal").click(function() {
    clearInputValues();
});

// Call the api when the filtered data is changed
$("#per_page, #sort_by, #sort").change(function() {
    $("#page_number").val("1");
    fetchTask();
});

// For pagination
$(document).on("click", ".page-link", function() {
    if($(this).text() == "Next" || $(this).text() == "Previous"){
        $("#page_number").val($(this).attr("alt_value"));
    } else {
        $("#page_number").val($(this).text());
    }
    fetchTask();
});

// Triggers when user delete specific task
$(document)
.on("click", ".delete_task", function(){
    Swal.fire({
        title: 'Are you sure you want to delete this task?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.isConfirmed){
            $.post($(this).parent("form").attr("action"), $(this).parent("form").serialize(), function() {
                toast_message('success', 'Deleted Successfully.');
            });
            fetchTask();
        }
    });
    return false;
})
// Triggers when user edit task data
.on("click", ".edit-task", function(){
    clearInputValues();
    $.get($(this).attr("href"), function(response){
        $(".modal-body").append(`<input type="hidden" id="method" name="_method" value="PUT">`);
        $("#save_update_frm").attr("action", `/api/v3/tasks/${response.id}`);
        $("#taskLabel").text(`Update Task`);
        $("#title").val(response.title);
        $("#description").val(response.description);
        $("#due_date").val(response.due_date);
        $("#btn_save").text("Update");
    });
});

// This will fetch the data from api endpoint
function fetchTask() {
    $.get($("#display").attr("action"), $("#display").serialize(), function(response) {
        displayTasks(response.data);
        displayPaginationData(response.meta);
    });
}

// Display list of tasks
function displayTasks(data) {
    let htmlStr = "";
    
    for (let index = 0; index < data.length; index++) {
        htmlStr += `<tr>
                        <td><h5 class="font-14 my-1">${data[index].title}</h5></td>
                        <td><h5 class="font-12 mt-1 fw-normal">${data[index].description}</h5></td>
                        <td><h5 class="font-12 mt-1 fw-normal">${data[index].due_date}</h5></td>
                        <td>
                            <form method="post" action="/api/v3/tasks/${data[index].id}">
                                <input type="hidden" name="_method" value="delete">
                                <a href="/api/v3/tasks/${data[index].id}" class="btn btn-info btn-sm edit-task" data-bs-toggle="modal" data-bs-target="#taskModal">Edit</a>
                                <button  type="submit" class="btn btn-danger btn-sm delete_task">Delete</button>
                            </form>
                        </td>
                    </tr>`;
    }

    if(data.length > 1){
        $(".table tbody").html("");
    }

    $(".table tbody").prepend(htmlStr);
}

function displayPaginationData(pagination_data) {
    let htmlStr = `<li class="page-item ${pagination_data.current_page == 1 ? "disabled": ""}" ${pagination_data.current_page != 1 ? "role='button'": ""}><a class="page-link" alt_value="${pagination_data.current_page - 1}">Previous</a></li>`;

    for(let index = 1; index <= pagination_data.total_pages; index++) {
        if ( index != pagination_data.current_page ) {
            htmlStr += `<li class="page-item"><a class="page-link" role="button">${index}</a></li>`;
        } else {
            htmlStr += `<li class="page-item active" aria-current="page"><span class="page-link">${index}</span></li>`;
        }
    }

    htmlStr += `<li class="page-item ${pagination_data.current_page == pagination_data.total_pages ? "disabled": ""}" ${pagination_data.current_page != pagination_data.total_pages ? "role='button'": ""}><a class="page-link" alt_value="${pagination_data.current_page + 1}">Next</a></li>`;

    let max_count = pagination_data.current_page * pagination_data.per_page;
    const minimum_count = max_count - pagination_data.per_page + 1;

    if (max_count > pagination_data.total) {
        max_count = pagination_data.total;
    }

    $("#pages").html("");
    $("#pages").append(htmlStr);
    $("#page_number").text(pagination_data.current_page);
    $("#pages_count").text(`Showing tasks ${minimum_count} to  ${max_count} of ${pagination_data.total}`);
}

// Clear text values
function clearInputValues(){
    $("#title").val("");
    $("#description").val("");
    $("#due_date").val("");
    $("#method").remove();
    $("#save_update_frm").attr("action", `/api/v3/tasks`);
    $("#taskLabel").text(`Add New Task`);
    $("#btn_save").text("Save");
}

// Disappear error messages after 2 seconds
function removeAlertMessages() {
    setTimeout(function(){
        $("#alerts").html("");
    }, 2000);
}

// Display success message | After delete and update
function toast_message(icon, message){
    Swal.fire({
        title: message,
        toast: true,
        position: 'top-end',
        icon: icon,
        showConfirmButton: false,
        timer: 2000,
        customClass: {
        popup: 'colored-toast'
    }
    })
}