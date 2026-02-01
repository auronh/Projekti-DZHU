<?php
class SiteContent {
    private $id;
    private $page;
    private $section;
    private $title;
    private $content;
    private $imagePath;
    private $displayOrder;
    private $isActive;
    private $updatedBy;
    private $updatedAt;

    public function __construct(
        $id = null,
        $page = '',
        $section = '',
        $title = '',
        $content = '',
        $imagePath = '',
        $displayOrder = 0,
        $isActive = true
    ) {
        $this->id = $id;
        $this->page = $page;
        $this->section = $section;
        $this->title = $title;
        $this->content = $content;
        $this->imagePath = $imagePath;
        $this->displayOrder = $displayOrder;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getPage() {
        return $this->page;
    }

    public function getSection() {
        return $this->section;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getDisplayOrder() {
        return $this->displayOrder;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getUpdatedBy() {
        return $this->updatedBy;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPage($page) {
        $this->page = $page;
    }

    public function setSection($section) {
        $this->section = $section;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
    }

    public function setDisplayOrder($displayOrder) {
        $this->displayOrder = $displayOrder;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    public function setUpdatedBy($updatedBy) {
        $this->updatedBy = $updatedBy;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'page' => $this->page,
            'section' => $this->section,
            'title' => $this->title,
            'content' => $this->content,
            'image_path' => $this->imagePath,
            'display_order' => $this->displayOrder,
            'is_active' => $this->isActive,
            'updated_by' => $this->updatedBy,
            'updated_at' => $this->updatedAt
        ];
    }
}
?>
