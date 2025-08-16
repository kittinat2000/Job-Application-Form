<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เลือกประเภท</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .option-box {
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 12px;
        }
        .option-box:hover {
            transform: scale(1.05);
            opacity: 0.85;
        }
    </style>
</head>
<body>

<div class="container text-center mt-5">
    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <a href="form_thai.php?nationality=Thai" class="text-decoration-none">
                <div class="option-box bg-primary text-white">
                    Thai
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="form_foreign.php?nationality=Foreign" class="text-decoration-none">
                <div class="option-box bg-success text-white">
                    Foreign
                </div>
            </a>
        </div>
    </div>
</div>

</body>
</html>
