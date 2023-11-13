<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px; /* Margin at the top, bottom, left, and right */
        }

        .card {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .card-header {
            background: #007bff;
            color: #fff;
            padding: 10px;
        }

        .card-body {
            padding: 20px;
        }

        form {
            margin: 0;
        }

        .mb-3 {
            margin: 15px 0; /* Margin at the top and bottom */
        }

        label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea.form-control {
            resize: vertical;
        }

        /* Hide the empty label */
        .custom-file-label::after {
            content: none;
        }

        /* Style the 'Browse' button */
        .input-group-append .btn {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
        }

        .btn-primary {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">Upload Image</div>
        <div class="card-body">
            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 row">
                    <label for="title" class="col-md-4 col-form-label text-md-end text-start">Title</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="title" name="title">
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                    <div class="col-md-6">
                        <textarea class="form-control" id="description" rows="5" name="description"></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="input-file" class="col-md-4 col-form-label text-md-end text-start">File input</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input-file" name="picture">
                                <label class="custom-file-label" for="input-file"></label>
                            </div>
                        </div>
                        @error('picture')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById("input-file").addEventListener("change", function () {
            var fileName = this.files[0].name;
            var label = document.querySelector(".custom-file-label");
            label.innerHTML = fileName;
        });
    </script>
</body>
</html>
