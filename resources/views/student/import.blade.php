<form action="{{route("student.upload")}}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="file" name="students" placeholder="EXCEL">
    <button type="submit">Upload</button>
</form>
