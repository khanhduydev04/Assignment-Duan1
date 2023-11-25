<?php
class Stories{
    var $id = null;
    var $image =  null;
    var $created_at = null;
    var $user_id = null;
    var $show = null;

    // Hiện danh sách stories
    public function getStories() {
        $db = new connect(); // Kết nối cơ sở dữ liệu
        $query = "SELECT * FROM stories";
        $result = $db->pdo_query($query);
        return $result;
    }
    
    // Hiện danh sách stories theo user_id
    public function getStoriesByUserId($user_id) {
        $db = new connect(); // Kết nối cơ sở dữ liệu
        $query = "SELECT * FROM stories WHERE user_id = :user_id";
        $params = [':user_id' => $user_id];
        $result = $db->pdo_query($query, $params);
        return $result;
    }

    // Xóa story
    public function deleteStory($story_id, $user_id) {
        $db = new connect(); // Kết nối cơ sở dữ liệu
        
        // Kiểm tra xem story_id có phải của user_id đăng nhập không trước khi xóa
        $query_check = "SELECT * FROM stories WHERE id = :story_id AND user_id = :user_id";
        $params_check = [
            ':story_id' => $story_id,
            ':user_id' => $user_id
        ];
        $result_check = $db->pdo_query($query_check, $params_check);
        
        if ($result_check) {
            // Nếu story_id và user_id đúng, thực hiện xóa câu chuyện
            $query_delete = "DELETE FROM stories WHERE id = :story_id";
            $params_delete = [
                ':story_id' => $story_id
            ];
            $result_delete = $db->pdo_query($query_delete, $params_delete);
            return $result_delete;
        } else {
            // Nếu story_id không phải của user_id đăng nhập, thông báo lỗi hoặc xử lý theo ý của bạn
            return false; // hoặc throw Exception("Unauthorized deletion");
        }
    }

    //Thêm bài post
    public function createStory($user_id, $image, $created_at, $show) {
        $db = new connect()
        $query = "INSERT INTO stories (user_id, image, created_at, show) VALUES (:user_id, :image, :created_at, :show)";
        $param = [
            ':user_id' => $user_id,
            ':image' => $image,
            ':created_at' => $created_at,
            ':show' => $show
        ];
        
        // Thực hiện chèn bài viết mới vào cơ sở dữ liệu
        $result = $db->pdo_query($query, $param);
        
        return $result;
    }

    
}
?>