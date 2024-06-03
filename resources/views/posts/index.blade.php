<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
    La liste des articles 

    <table>
      <thead>
        <th>id</th>
        <th>title</th>
        <th>content</th>
        <th>Actions</th>
      </thead>

      <tbody>
        @foreach ($posts as $post)
        <tr>
          <td> {{ $post->id }} </td>
          <td> {{ $post->title }} </td>
          <td> {{ $post->content }} </td>
          <td> <a href=" {{ route('posts.show',$post) }} ">Show</a> </td>
          
        </tr>
            
        @endforeach

      </tbody>
    </table>
</body>
</html>