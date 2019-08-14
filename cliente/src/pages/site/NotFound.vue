<template>
    <main>
        <div>
            <main-header></main-header>
        </div>
        <div class="page-body d-flex align-items-center justify-content-center">
            <div class="box d-flex flex-column align-items-center justify-content-center">       
                <div class="title text-center">
                <img src="../../assets/favicon.png" alt="">
                    <h2>Oops, página não encontrada.</h2>
                </div>
                <div class="mt-5 text-center">
                    <div>Pesquise por alguma campanha que esteja interessado no campo de busca</div>
                    <div >ou</div>
                    <div >
                        <router-link to="/" class="link">
                            Clique aqui para voltar a página inicial
                        </router-link>    
                        
                    </div>
                </div>
            </div>

        </div>
    </main>
</template>

<script>

</script>

<style lang="scss" scoped>
@import "Styles/colors.scss";

.page-body {
    background-color: $orange;
    height: 100%;
    width: 100%; 
    .box {
        background-color: white;
        padding: 1rem;
        border-radius: 0.25rem;
        width: 90%;
        height: 90%;
        box-shadow: 0px 0px 5px 7px $blue;
    }
}
.title {
    color: $blue;
}
.link {
    color: $orange;
}
</style>
