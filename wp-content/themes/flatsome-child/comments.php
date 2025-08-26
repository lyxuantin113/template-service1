<?php
if (post_password_required()) {
    return;
}

$commenter = wp_get_current_commenter();

$args = [
    'title_reply' => '<span class="comment-title">Trả lời</span>',
    'label_submit' => 'Phản hồi',
    'class_form' => 'custom-comment-form', // Thêm class riêng để bạn style

    'comment_notes_before' => '<p>Email của bạn sẽ không được hiển thị công khai. Các trường bắt buộc được đánh dấu *</p>',

    'fields' => [
        'author' =>
        '<div class="form-group">
                <input id="author" name="author" type="text" class="form-control" placeholder="Name *" value="' . esc_attr($commenter['comment_author']) . '" required>
            </div>',
        'email' =>
        '<div class="form-group">
                <input id="email" name="email" type="email" class="form-control" placeholder="Email *" value="' . esc_attr($commenter['comment_author_email']) . '" required>
            </div>',
    ],

    'comment_field' =>
    '<div class="form-group">
            <textarea id="comment" name="comment" class="form-control" placeholder="Viết bình luận của bạn" rows="5" required></textarea>
        </div>',

    'submit_button' =>
    '<button type="submit" class="btn btn-primary">%4$s</button>', // %4$s là label_submit
];

comment_form($args);
