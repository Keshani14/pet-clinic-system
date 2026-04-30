<?php
$pageTitle = 'Admin Dashboard — Pet Clinic';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="card card--lg">
    <div class="card-header">
        <span class="paw-icon" aria-hidden="true">👑</span>
        <h1>Admin Dashboard</h1>
        <p>Welcome back, <strong><?php echo Auth::name(); ?></strong>!</p>
    </div>
    
    <div class="card-body">
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash_error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
            </div>
        <?php endif; ?>

        <h2 class="mb-20">🛡️ Account Approval Requests</h2>
        
        <?php if (empty($pendingUsers)): ?>
            <div class="empty-state">
                <span class="icon-lg">✅</span>
                <p>No pending registration requests at the moment.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User Details</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingUsers as $user): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></strong>
                                    <br><small class="text-gray-500"><?php echo htmlspecialchars($user['email']); ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $user['role']; ?>">
                                        <?php echo ucfirst($user['role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-gray-600">⏳ Pending</span>
                                </td>
                                <td class="text-right">
                                    <a href="?url=admin/approve/<?php echo $user['id']; ?>" class="btn-pill btn-sm" style="background: #10b981;">Approve</a>
                                    <a href="?url=admin/reject/<?php echo $user['id']; ?>" class="btn-pill btn-sm btn-danger">Reject</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="divider-line"></div>
        <div class="text-center my-20">
            <a href="?url=pet/listPets" class="btn-secondary">Manage All Pets</a>
            <a href="?url=user/logout" class="btn-secondary" style="margin-left: 10px;">Log Out</a>
        </div>
    </div>
</div>

<style>
.badge {
    padding: 4px 8px;
    border-radius: 99px;
    font-size: 0.75rem;
    font-weight: 700;
}
.badge-vet { background: #dcfce7; color: #166534; }
.badge-nurse { background: #dbeafe; color: #1e40af; }
.badge-owner { background: #fef9c3; color: #854d0e; }
</style>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
