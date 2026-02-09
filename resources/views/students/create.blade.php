<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Student</title>
    <style>
    *{
        box-sizing: border-box;
    }

    body{
        font-family: Arial, sans-serif;
        background:#f5f6f8;
        margin:0;
        padding:24px;                 /* সব দিক একই */
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;           /* vertically center */
    }

    .container{
        width:100%;
        max-width:650px;
        background:#fff;
        padding:28px;                 /* সব দিক একই */
        border:1px solid #e5e7eb;
        border-radius:14px;
        box-shadow:0 12px 30px rgba(0,0,0,.08);
    }

    h2{
        margin:0 0 18px;
        font-size:38px;
        line-height:1.1;
    }

    .msg{
        padding:12px 14px;
        border-radius:10px;
        margin-bottom:14px;
        font-size:14px;
    }
    .msg-success{ background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; }
    .msg-error{ background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }

    label{
        font-weight:700;
        display:block;
        margin:18px 0 10px;
        font-size:26px;
    }

    input{
        width:100%;
        padding:16px 16px;
        border:1px solid #cbd5e1;
        border-radius:12px;
        outline:none;
        font-size:18px;
        background:#fff;
    }

    input:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 4px rgba(37,99,235,.16);
    }

    .hint{
        color:#6b7280;
        font-size:18px;
        margin-top:10px;
    }

    .actions{
        display:flex;
        gap:14px;
        margin-top:24px;
    }

    .btn{
        padding:16px 22px;
        border-radius:14px;
        border:1px solid transparent;
        text-decoration:none;
        cursor:pointer;
        font-weight:700;
        font-size:20px;
    }

    .btn-primary{
        background:#2563eb;
        color:#fff;
    }
    .btn-primary:hover{
        background:#1d4ed8;
    }

    .btn-outline{
        background:#fff;
        border-color:#111827;
        color:#111827;
    }
    .btn-outline:hover{
        background:#f3f4f6;
    }

    ul{ margin:10px 0 0; padding-left:20px; }
</style>

</head>
<body>
    <div class="container">
        <h2>Add Student</h2>

        @if (session('success'))
            <div class="msg msg-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="msg msg-error">
                <strong>Please fix the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('students.store') }}">
            @csrf

            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="">
            <div class="hint">Enter full name</div>

            <label>Student ID</label>
            <input type="text" name="student_id" value="{{ old('student_id') }}" placeholder="">
            <div class="hint">Must be unique</div>

            <label>Age</label>
            <input type="number" name="age" value="{{ old('age') }}" placeholder="" min="1" max="120">

            <div class="actions">
                <button class="btn btn-primary" type="submit">Save</button>

                <a class="btn btn-outline" href="{{ route('students.index') }}">
                    Back to Students
                </a>
            </div>
        </form>
    </div>
</body>
</html>
