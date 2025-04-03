<?php
namespace Controllers\Admin;

use Models\ActivityLog;

class ActivityLogController {
    private $activityLogModel;

    public function __construct() {
        $this->activityLogModel = new ActivityLog();
    }

    public function index() {
        $logs = $this->activityLogModel->getAllLogs();
        $data = ['title' => 'Nhật ký hoạt động', 'logs' => $logs];
        require_once APP_ROOT . '/Views/admin/activity_log/index.php';
    }
}