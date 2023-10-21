<?php

require_once('inc/conecta.php');

if(isset($_GET['excluir'])){
    $id = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);

    if($id){
        $con->exec('DELETE FROM meta WHERE id=' .$id);
    }
    header('Location: index.php');
    exit;
}

//Realiza a conexão,pegar todos os dados da tabela metas e guarda na variável $results
$results = $con->query('select * from meta')->fetchAll();

$array_situacao = [1 => 'Aberta', 2 => 'Em andamento', 3 => 'Realizada'];

include_once("inc/header.php");

?>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Minhas metas</h5>
        <a class="btn btn-success" href="adicionarMeta.php">Adicionar meta</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($results as $item): ?>
                    <tr>
                        <td><?= $item['ds_meta']?></td>
                        <td><?= $array_situacao[$item['st_meta']]?></td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="adicionarMeta.php?id=<?= $item['id']?>">Editar</a>
                            <button class="btn btn-sm btn-danger" onclick="excluir(<?= $item['id']?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>    
            </tbody>
        </table>
    </div>
</div>

<script>
    function excluir(id){
        if(confirm("Deseja excluir esta meta?")){
            window.location.href = "index.php?excluir=" + id;
        }
    }
</script>

<?php include_once("inc/footer.php"); ?>