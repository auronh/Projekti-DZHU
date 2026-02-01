<?php
class ContactMessageRepository {
    private $connection;

    public function __construct() {
        $db = DatabaseConnection::getInstance();
        $this->connection = $db->getConnection();
    }

    public function create(ContactMessage $message) {
        try {
            $sql = "INSERT INTO contact_messages (name, email, subject, message) 
                    VALUES (:name, :email, :subject, :message)";
            
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute([
                ':name' => $message->getName(),
                ':email' => $message->getEmail(),
                ':subject' => $message->getSubject(),
                ':message' => $message->getMessage()
            ]);

            if ($result) {
                $message->setId($this->connection->lastInsertId());
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error creating contact message: " . $e->getMessage());
            return false;
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
            $stmt = $this->connection->query($sql);
            
            $messages = [];
            while ($data = $stmt->fetch()) {
                $messages[] = $this->mapToContactMessage($data);
            }
            return $messages;
        } catch (PDOException $e) {
            error_log("Error getting all contact messages: " . $e->getMessage());
            return [];
        }
    }

    public function getUnread() {
        try {
            $sql = "SELECT * FROM contact_messages WHERE is_read = 0 ORDER BY created_at DESC";
            $stmt = $this->connection->query($sql);
            
            $messages = [];
            while ($data = $stmt->fetch()) {
                $messages[] = $this->mapToContactMessage($data);
            }
            return $messages;
        } catch (PDOException $e) {
            error_log("Error getting unread messages: " . $e->getMessage());
            return [];
        }
    }

    public function markAsRead($id) {
        try {
            $sql = "UPDATE contact_messages SET is_read = 1 WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error marking message as read: " . $e->getMessage());
            return false;
        }
    }

    
    public function delete($id) {
        try {
            $sql = "DELETE FROM contact_messages WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting message: " . $e->getMessage());
            return false;
        }
    }

    public function getUnreadCount() {
        try {
            $sql = "SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0";
            $stmt = $this->connection->query($sql);
            $result = $stmt->fetch();
            return $result ? (int)$result['count'] : 0;
        } catch (PDOException $e) {
            error_log("Error getting unread count: " . $e->getMessage());
            return 0;
        }
    }

    private function mapToContactMessage($data) {
        $message = new ContactMessage(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['subject'],
            $data['message'],
            $data['is_read']
        );
        $message->setCreatedAt($data['created_at']);
        return $message;
    }
}
?>
