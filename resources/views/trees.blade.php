<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de arboles</title>
</head>
<body>
    <h1>Lista de Árboles</h1>
    @foreach ($trees as $tree)

        <p>Id: {{$tree->id}}</p>
        <p>User Id: {{$tree->user_id}}</p>
        <p>Seed Id: {{$tree->seed_id}}</p>
        <p>Level: {{$tree->level}}</p>
        <p>Health: {{$tree->health}}</p>
        <p>Progress: {{$tree->progress}}</p>
        <p>Status: {{$tree->status}}</p>
        <p>Next Care At: {{$tree->next_care_at}}</p>

        <hr>

    @endforeach
</body>
</html>