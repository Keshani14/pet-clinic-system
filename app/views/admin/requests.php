<?php
$pageTitle = 'Staff Management — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/admin_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">🛡️</span>
                <h1>Staff Management</h1>
                <p>Approve new registrations or manage existing Vet and Nurse accounts.</p>
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

                <?php if (empty($staffUsers)): ?>
                    <div class="empty-state">
                        <span class="icon-lg">👥</span>
                        <p>No staff registration records found.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Staff Member</th>
                                    <th>Role</th>
                                    <th>Current Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staffUsers as $user): ?>
                                    <tr>
                                        <td>
                                            <div style="display: flex; flex-direction: column;">
                                                <strong style="color: var(--gray-800);"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></strong>
                                                <small class="text-gray-500"><?php echo htmlspecialchars($user['email']); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo $user['role']; ?>">
                                                <?php echo ucfirst($user['role']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($user['status'] === 'approved'): ?>
                                                <span class="text-green-bold">✅ Approved</span>
                                            <?php elseif ($user['status'] === 'rejected'): ?>
                                                <span class="text-danger-bold">❌ Rejected</span>
                                            <?php else: ?>
                                                <span class="text-gray-600">⏳ Pending Review</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right">
                                            <?php if ($user['status'] === 'pending'): ?>
                                                <a href="?url=admin/approve/<?php echo $user['id']; ?>" class="btn-pill btn-sm btn-approve">Approve</a>
                                                <a href="?url=admin/reject/<?php echo $user['id']; ?>" class="btn-pill btn-sm btn-danger">Reject</a>
                                            <?php elseif ($user['status'] === 'approved'): ?>
                                                <button class="btn-pill btn-sm" disabled style="background: var(--gray-400); cursor: default; opacity: 0.7;">Approved</button>
                                                <a href="?url=admin/reject/<?php echo $user['id']; ?>" class="btn-secondary btn-sm btn-danger" style="padding: 6px 12px; margin-left: 5px;">Revoke</a>
                                            <?php else: ?>
                                                <a href="?url=admin/approve/<?php echo $user['id']; ?>" class="btn-pill btn-sm btn-approve">Approve</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="divider-line"></div>
                <div class="text-center">
                    <a href="?url=admin/dashboard" class="link-back">← Back to Dashboard</a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
