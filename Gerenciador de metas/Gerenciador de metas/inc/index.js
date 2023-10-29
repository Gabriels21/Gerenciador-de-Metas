document.querySelector('#switch').addEventListener('click',()=>{
    document.body.classList.toggle('dark');
})

function excluir(id){
    if(confirm("Deseja excluir esta meta?")){
        window.location.href = "index.php?excluir=" + id;
    }
}