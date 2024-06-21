<?php
function getStatusText($status) {
    switch ($status) {
        case 1:
            return "Chưa giải quyết";
        case 2:
            return "Đang Xử lý";
        case 3:
            return "Đang vận chuyển";
        case 4:
            return "Đã giao hàng";
        case 5:
            return "Đã hủy";
        case 6:
            return "Hoàn trả";
        default:
            return "Unknown";
    }
}