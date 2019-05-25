<h5><?= __('Alunos da turma')  ?></h5>
<table class="table table-striped table-hover table-sm">
    <tbody>
      <?php foreach($users as $user): ?>
      <tr>
        <td><?= $user->user->first_name . ' ' . $user->user->last_name  ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
</table>
