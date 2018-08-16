<class class="wrap">
    <h1>ایجاد فاکتور جدید</h1>
    <form action="" method="post">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">کاربر:</th>
                <td>
                    <input type="text" name="user_id">
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">مبلغ:</th>
                <td>
                    <input type="text" name="amount"> تومان
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">توضیحات:</th>
                <td>
                    <input type="text" name="description">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">تاریخ انقضاء:</th>
                <td>
                    <input type="datetime-local" name="expired_at">
                </td>
            </tr>

        </table>
        <?php submit_button('ذخیره اطلاعات', 'primary', 'save_new_factor') ?>
    </form>
</class>