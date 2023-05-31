<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- -----------Bootstrap----------->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- -----------Jquery----------->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- -----------Sweet Alert----------->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Task Manager</title>
    <style>
        .swal2-confirm{
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="col-lg-10 mx-auto mt-4">
        <div class="card">
            <div class="card-body">
                <form action="/api/v3/tasks" method="GET" id="display">
                    <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
                        <h4 class="header-title">Tasks</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">Add New Task</button>
                    </div>
                    <div class="row gy-2 gx-2 mb-2 align-items-center justify-content-xl-start justify-content-between">
                        <div class="col-auto">Display</div>
                        <div class="col-auto">
                            <select class="form-select" name="per_page" id="per_page" class="d-inline-block">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-auto">Tasks</div>
                        <div class="col-auto">
                            <select class="form-select" name="sort_by" id="sort_by">
                                <option value="id" selected>Sort By</option>
                                <option value="title">Title</option>
                                <option value="due_date">Due Date</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <select class="form-select" name="sort" id="sort">
                                <option value="desc" selected>Descending</option>
                                <option value="asc">Ascending</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                    <div class="row mt-4">
                        <div class="col-md-6"><p class="fs-5" id="pages_count">1 out of 2 pages</p></div>
                        <div class="col-md-6">
                            <input type="hidden" name="page_number" id="page_number" value="1">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end" id="pages">
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                </form>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>

    <!-- Modal for Save and Update -->
    <div class="modal fade" id="taskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="taskLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/api/v3/tasks" id="save_update_frm" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="taskLabel">Add New Task</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alerts">
                            
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" placeholder="Due Date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="close_modal" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>