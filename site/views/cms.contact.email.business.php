<p>
    A fost inregistrata o noua cerere de contact cu datele de mai jos.<br />
    Pentru a gestiona cererea <a href="<?= makeLink(LINK_ABSOLUTE) . 'admin/index.php?page=cms.contact.edit&edit=' . $data['id'] ?>" target="_blank"><strong>click aici</strong></a>.
</p>
<table>
    <tr>
        <td>Nume:</td>
        <td><?= $data['name'] ?></td>
    </tr>
    <tr>
        <td>Email:</td>
        <td><?= $data['email'] ?></td>
    </tr>
    <tr>
        <td>Telefon:</td>
        <td><?= $data['phone'] ?></td>
    </tr>
    <tr>
        <td>Volum zilnic de transport:</td>
        <td><?= $data['volume'] ?></td>
    </tr>
    <tr>
        <td style="vertical-align: top;">Mesaj:</td>
        <td><?= nl2br($data['message']) ?></td>
    </tr>
</table>