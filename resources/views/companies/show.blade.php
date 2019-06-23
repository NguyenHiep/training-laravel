<!DOCTYPE html>
<html>
<head>
    <title>Company {{ $company->id }}</title>
</head>
<body>
<h1>Company {{ $company->id }}</h1>
<ul>
    <li>Name: {{ $company->name }}</li>
    <li>Type: {{ $company->type }}</li>
    <li>Size: {{ $company->size }}</li>
    <li>Address: {{ $company->address }}</li>
</ul>
</body>
</html>