<?php
class ContactController {
    private $contactRepository;

    public function __construct() {
        $this->contactRepository = new ContactMessageRepository();
    }

    public function submitContact($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = "Name is required";
        }

        if (empty($data['email'])) {
            $errors[] = "Email is required";
        } elseif (!isValidEmail($data['email'])) {
            $errors[] = "Invalid email format";
        }

        if (empty($data['message'])) {
            $errors[] = "Message is required";
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $message = new ContactMessage();
        $message->setName(sanitize($data['name']));
        $message->setEmail(sanitize($data['email']));
        $message->setSubject(isset($data['subject']) ? sanitize($data['subject']) : '');
        $message->setMessage(sanitize($data['message']));

        if ($this->contactRepository->create($message)) {
            return ['success' => true, 'message' => 'Thank you for your message! We will get back to you soon.'];
        }

        return ['success' => false, 'errors' => ['Failed to send message. Please try again.']];
    }

    public function getAllMessages() {
        return $this->contactRepository->getAll();
    }

    public function getUnreadMessages() {
        return $this->contactRepository->getUnread();
    }

    public function markAsRead($id) {
        return $this->contactRepository->markAsRead($id);
    }

    public function deleteMessage($id) {
        if ($this->contactRepository->delete($id)) {
            return ['success' => true, 'message' => 'Message deleted successfully!'];
        }
        return ['success' => false, 'errors' => ['Failed to delete message']];
    }

    public function getUnreadCount() {
        return $this->contactRepository->getUnreadCount();
    }
}
?>
