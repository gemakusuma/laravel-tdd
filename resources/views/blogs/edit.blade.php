<h1>Edit Blog Baru</h1>
<form action="/blog/{{$blog->id}}" method="POST">
    <input type="text" name="title" value="{{$blog->slug}}"> <br>
    <textarea name="subject" name="subject" rows="8" cols="80">{{$blog->subject}}</textarea><br>
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="put">
    <input type="submit" value="Post blog">
</form>
