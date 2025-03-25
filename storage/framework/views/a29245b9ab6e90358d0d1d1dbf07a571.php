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
    <form action="<?php echo e(route('roles.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="text" name="name" placeholder="New Role" required>
        <button type="submit">Add Role</button>
    </form>

    <!-- Add Permission Form -->
    <form action="<?php echo e(route('permissions.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
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
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($role->name); ?></td>
                        <td>
                            <form action="<?php echo e(route('permissions.assign')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="role_id" value="<?php echo e($role->id); ?>">
                                <div class="checkbox-group">
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label>
                                            <input type="checkbox" name="permissions[]" value="<?php echo e($permission->name); ?>" 
                                                   <?php echo e($role->hasPermissionTo($permission->name) ? 'checked' : ''); ?>>
                                            <?php echo e($permission->name); ?>

                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <button type="submit">Update Permissions</button>
                            </form>
                        </td>
                        <td class="action-buttons">
                            <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <form action="<?php echo e(route('permissions.update', $permission->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <input type="text" name="name" value="<?php echo e($permission->name); ?>" required>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                        <td class="action-buttons">
                            <form action="<?php echo e(route('permissions.destroy', $permission->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <form action="<?php echo e(route('roles.update', $role->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <input type="text" name="name" value="<?php echo e($role->name); ?>" required>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                        <td class="action-buttons">
                            <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\Spatie-looks\resources\views/spatielook/index.blade.php ENDPATH**/ ?>