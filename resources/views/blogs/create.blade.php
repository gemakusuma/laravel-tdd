@foreach ($errors->all() as $error)
    <li>{{$error}}</li>
@endforeach

<h1>Bikin Blog Baru</h1>
<form action="/blog" method="POST">
    <input type="text" name="title" placeholder="title"> <br>
    <textarea name="subject" name="subject" rows="8" cols="80"></textarea><br>
    {{ csrf_field() }}
    <input type="submit" value="Post blog">
</form>
