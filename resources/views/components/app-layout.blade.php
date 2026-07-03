<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow px-6 py-4 mb-6">
        <a href="{{ route('registrations.index') }}" class="text-xl font-bold text-indigo-600">
            Registration Management
        </a>
    </nav>

    <main>
        {{ $slot }}
    </main>
</body>
</html>