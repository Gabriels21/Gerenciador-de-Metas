<?php

require_once('inc/conecta.php');

$id = 0;
$descricao = '';
$situacao = 1;

if(isset($_POST['id'])){
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $situacao = filter_input(INPUT_POST, "situacao", FILTER_SANITIZE_NUMBER_INT);

    if(!$id){
        $stm = $con->prepare("INSERT INTO meta (ds_meta, st_meta) VALUES (:descricao, :situacao)");
    }else{
    $stm = $con->prepare("UPDATE meta SET ds_meta = :descricao, st_meta=:situacao WHERE id=:id");
    $stm->bindValue(':id', $id);
    }

    $stm->bindValue(':descricao', $descricao);
    $stm->bindValue(':situacao', $situacao);
    $stm->execute();
    
    header('Location: index.php');
    exit;
}

if(isset($_GET['id'])){
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if(!$id){
        header('Location: index.php');
        exit;
    }

    $stm = $con->prepare('SELECT * FROM meta WHERE id=:id');
    $stm->bindValue('id', $id);
    $stm->execute();
    $result = $stm->fetch();

    if(!$result){
        header('Location: index.php');
        exit;
    }

    $descricao = $result['ds_meta'];
    $situacao = $result['st_meta'];

}

include_once('inc/header.php');

?>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5><?= $id?'Editar Meta ':'Adicionar meta' ?></h5>
    </div>
    <form method="post" autocomplete="off">
    <div class="card-body">

        <input type="hidden" name="id" value="<?=$id?>"/>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" name="descricao" value="<?=$descricao?>" required>
        </div>

        <div class="form-group">
            <label for="situacao">Situação</label>
            <select name="situacao" class="form-select">
                <option value="1" <?= $situacao == 1?'selected':'' ?> >Aberta</option>
                <option value="2"  <?= $situacao == 2?'selected':'' ?> >Em andamento</option>
                <option value="3"  <?= $situacao == 3?'selected':'' ?>>Realizada</option>
            </select>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="index.php" class="btn btn-primary">Voltar</a>
    </div>
    </form>
</div>


<?php include_once('inc/footer.php'); ?>