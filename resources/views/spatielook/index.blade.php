<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spatie Look 'n Listen</title>
    <style>
        /* Reset some default styles */
        body, h1, table, form, input, button {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Basic styles for the page */
        body {
            background-color: #fff;
            color: #333;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            color: #222;
        }

        /* Form styles */
        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 70%;
            margin-right: 10px;
            color: #333;
        }

        form button {
            padding: 10px 15px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #444;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #333;
            color: white;
        }

        table tr:hover {
            background-color: #f5f5f5;
        }

        /* Action buttons */
        .action-buttons button {
            padding: 6px 10px;
            margin: 5px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .action-buttons button:hover {
            background-color: #444;
        }

        .action-buttons form {
            display: inline-block;
        }

        /* Checkbox styles */
        .checkbox-group label {
            display: block;
            margin: 5px 0;
            color: #333;
        }

        .checkbox-group input {
            margin-right: 10px;
        }

        /* Table wrapper for better layout control */
        .table-wrapper {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <h1>Spatie Look 'n Listen</h1>

    <!-- Add Role Form -->
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="New Role" required>
        <button type="submit">Add Role</button>
    </form>

    <!-- Add Permission Form -->
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="New Permission" required>
        <button type="submit">Add Permission</button>
    </form>

    <!-- Roles and Permissions Management Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <form action="{{ route('permissions.assign') }}" method="POST">
                                @csrf
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                <div class="checkbox-group">
                                    @foreach ($permissions as $permission)
                                        <label>
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            {{ $permission->name }}
                                        </label>
                                    @endforeach
                                </div>
                                <button type="submit">Update Permissions</button>
                            </form>
                        </td>
                        <td class="action-buttons">
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Permissions Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Permission Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>
                            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $permission->name }}" required>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                        <td class="action-buttons">
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Roles Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>
                            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $role->name }}" required>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                        <td class="action-buttons">
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
