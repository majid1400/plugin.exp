<tr>
    <th><?php echo $factor->factor_code ?></th>
    <th><?php echo $factor->display_name ?></th>
    <th><?php echo $factor->factor_amount ?></th>
    <th><?php echo $factor->factor_created_at ?></th>
    <th><?php echo $factor->factor_updated_at ?></th>
    <th><?php echo $factor->factor_expired_at ?></th>
    <th><?php echo wpf_status($factor->factor_status) ?></th>
</tr>