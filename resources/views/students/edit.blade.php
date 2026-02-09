<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Student</title></head>
<body>
<h2>Edit Student</h2>

@if ($errors->any())
  <ul style="color:red;">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
@endif

<form method="POST" action="{{ route('students.update', $student->id) }}">
  @csrf
  @method('PUT')

  <label>Name</label><br>
  <input type="text" name="name" value="{{ old('name', $student->name) }}"><br><br>

  <label>Student ID</label><br>
  <input type="text" name="student_id" value="{{ old('student_id', $student->student_id) }}"><br><br>

  <label>Age</label><br>
  <input type="number" name="age" value="{{ old('age', $student->age) }}"><br><br>

  <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('students.index') }}">Back</a>
</body>
</html>
