<?php

class ClientBookingController
{
    protected $bookingModel;

    public function __construct()
    {
        global $dbConnection;
        $this->bookingModel = new ClientBooking($dbConnection ?? null);
    }

    /**
     * Hiển thị form Đặt tour (sau khi chọn Tour).
     */
    public function formBooking($tourId)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?redirect=/book-tour&tour_id=' . $tourId);
            exit;
        }
        // ...
        // renderView('client/booking_form', compact('tourId'));
        echo "<h1>Đặt Tour #$tourId</h1><p>Hiển thị form điền thông tin khách hàng và thanh toán.</p>";
    }

    /**
     * Xử lý Đặt tour.
     */
    public function processBooking()
    {
        // Lấy dữ liệu POST
        $bookingData = $_POST;
        $bookingData['user_id'] = $_SESSION['user_id'] ?? null;

        if (!$bookingData['user_id']) {
            // Xử lý lỗi: Chưa đăng nhập
            header('Location: /login');
            exit;
        }

        $newBookingId = $this->bookingModel->createBooking($bookingData);

        if ($newBookingId) {
            header('Location: /view-itinerary?booking_id=' . $newBookingId);
            exit;
        } else {
            // Xử lý lỗi đặt tour
            // renderView('client/booking_form', ['error' => 'Đặt tour thất bại.']);
        }
    }

    /**
     * Danh sách Booking của tôi. (Đã đặt)
     */
    public function listBookings()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $bookings = $this->bookingModel->getUserBookings($_SESSION['user_id']);
        // renderView('client/my_bookings', compact('bookings'));
        echo "<h1>Các Tour đã Đặt</h1>";
        print_r($bookings);
    }

    /**
     * Xem Lịch trình chi tiết (Xem lịch trình).
     */
    public function viewItinerary($bookingId)
    {
        $itinerary = $this->bookingModel->getItineraryByBookingId($bookingId);
        // renderView('client/itinerary_detail', compact('itinerary', 'bookingId'));
        echo "<h1>Lịch Trình Booking #$bookingId</h1>";
        print_r($itinerary);
    }

    /**
     * Theo dõi Trạng thái Chuyến đi (Theo dõi được chuyến đi).
     */
    public function trackTripStatus($bookingId)
    {
        $status = $this->bookingModel->getTripStatus($bookingId);
        // renderView('client/trip_tracking', compact('status', 'bookingId'));
        echo "<h1>Theo Dõi Chuyến Đi #$bookingId</h1>";
        echo "<p>Trạng thái hiện tại: <strong>" . htmlspecialchars($status) . "</strong></p>";
    }
}
