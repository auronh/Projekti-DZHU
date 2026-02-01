<?php
require_once '../../config/config.php';
$authController = new AuthController();
$authController->requireAdmin();
$contactController = new ContactController();
if (isset($_GET['read']) && $_GET['read']) {
    $contactController->markAsRead((int)$_GET['read']);
    redirect('messages.php');
}
if (isset($_GET['delete']) && $_GET['delete']) {
    $contactController->deleteMessage((int)$_GET['delete']);
    redirect('messages.php');
}
$messages = $contactController->getAllMessages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <header>
        <a href="dashboard.php" class="logo"><?php echo SITE_NAME; ?> Admin</a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="../public/logout.php">Logout</a>
        </nav>
    </header>
    <div class="admin-container">
        <h1>Contact Messages</h1>
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><span class="badge <?php echo $message->getIsRead() ? 'badge-read' : 'badge-unread'; ?>"><?php echo $message->getIsRead() ? 'Read' : 'Unread'; ?></span></td>
                        <td><?php echo htmlspecialchars($message->getName()); ?></td>
                        <td><?php echo htmlspecialchars($message->getEmail()); ?></td>
                        <td><?php echo htmlspecialchars($message->getSubject()); ?></td>
                        <td class="message-preview"><?php echo htmlspecialchars($message->getMessage()); ?></td>
                        <td><?php echo date('M d, Y', strtotime($message->getCreatedAt())); ?></td>
                        <td class="action-buttons">
                            <?php if (!$message->getIsRead()): ?>
                            <a href="?read=<?php echo $message->getId(); ?>" class="btn-small btn-view">Mark Read</a>
                            <?php endif; ?>
                            <a href="?delete=<?php echo $message->getId(); ?>" class="btn-small btn-delete" onclick="return confirm('Delete this message?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
