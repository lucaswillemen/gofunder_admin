<template>

    <md-tabs class="md-transparent" md-alignment="fixed">
        <md-tab id="tab-home" md-label="Objetivo" md-icon="home">
            <div class="md-layout md-gutter md-alignment-center-center">
                <md-layout class="md-layout-item  md-size-25">
                    <md-card class="md-layout md-alignment-center-center md-primary">
                            <md-empty-state class="md-empty-state-icon-first"
                              md-icon="account_balance_wallet"
                              md-label="Arrecadar fundos"
                              md-description="Receba doacoes e envie recompensas para os apioadores da sua campanha em forma de gratidao pela ajuda.">
                            </md-empty-state>

                    </md-card>
                    <br>
                    <br>
                    <md-card class="md-layout md-alignment-center-center md-primary">
                            <md-empty-state class="md-empty-state-icon-first"
                              md-icon="fast_forward"
                              md-label="Acelerar seu projeto"
                              md-description="Mostre seu projeto para tutores e investidores para ganhar apoio qualificado para fazer sua ideia acontecer.">
                            </md-empty-state>
                            

                    </md-card>
                </md-layout>
                <md-layout class="md-layout-item  md-size-25">
                    <md-card class="md-layout md-alignment-center-center md-primary">
                            <md-empty-state class="md-empty-state-icon-first"
                              md-icon="shopping_basket"
                              md-label="Venda antes de terminar"
                              md-description="Faca uma prevenda do seu produto enquanto vc finaliza seu projeto e analise o comportamento e aprovacao do publico.">
                            </md-empty-state>
                            

                    </md-card>
                    <br>
                    <br>
                    <md-card class="md-layout md-alignment-center-center md-primary">

                            <md-empty-state class="md-empty-state-icon-first"
                              md-icon="share"
                              md-label="Compartilhe sua ideia"
                              md-description="Encontre acionistas que irao ajudar a financiar seu projeto e divida os lucros com quem te ajudou.">
                            </md-empty-state>
                            

                    </md-card>
                </md-layout>
            </div>
        </md-tab>
        <md-tab id="tab-pages" md-label="Caracteristicas" md-icon="pages">
            <div class="md-layout md-gutter md-alignment-center-center">
                <md-card class="md-layout-item md-size-50 md-small-size-100">
                    <md-card-header class="md-layout md-gutter md-alignment-center-center">
                        <div class="md-title">Vamos identificar o tipo do seu projeto</div>
                    </md-card-header>
                    <md-card-content>
                        <md-field>
                            <label for="movie">O seu projeto esta sendo desenvolvido por</label>
                            <md-select v-model="movie" name="movie" id="movie">
                                <md-option value="fight-club">Uma pessoa ou grupo</md-option>
                                <md-option value="fight-club">Uma empresa instalada</md-option>
                                <md-option value="fight-club">Organizacao sem fins lucrativos</md-option>
                            </md-select>
                        </md-field>
                        <md-field>
                            <label for="movie">Qual tipo de seu projeto</label>
                            <md-select v-model="movie" name="movie" id="movie">
                                <md-option value="fight-club">Software / Aplicativo</md-option>
                                <md-option value="fight-club">Produto</md-option>
                                <md-option value="fight-club">Servico</md-option>
                            </md-select>
                        </md-field>
                        <md-field>
                            <label for="movie">Escolha a categoria que melhor se adapta ao seu projeto</label>
                            <md-select v-model="movie" name="movie" id="movie">
                                <md-option value="fight-club">Eletronicos</md-option>
                                <md-option value="fight-club">Viagens</md-option>
                                <md-option value="fight-club">Bem estar e saude</md-option>
                            </md-select>
                        </md-field>
                        <md-field>
                            <label for="movie">Como voce gostaria de receber seus fundos</label>
                            <md-select v-model="movie" name="movie" id="movie" md-layout="box">
                                <md-option value="fight-club">Moeda local</md-option>
                                <md-option value="fight-club">Dolar</md-option>
                                <md-option value="fight-club">Criptomoedas</md-option>
                            </md-select>
                        </md-field>
                    </md-card-content>
                </md-card>
            </div>
        </md-tab>
        <md-tab id="tab-posts" md-label="Informacoes" md-icon="list">
            <div class="md-layout md-gutter md-alignment-center-center">
                <md-card class="md-layout-item md-size-50 md-small-size-100">
                    <md-card-header class="md-layout md-gutter md-alignment-center-center">
                        <div class="md-title">Vamos ver como esta o andamento</div>
                    </md-card-header>
                    <md-card-content>
                        <md-field>
                            <label>Qual o nome/titulo do seu projeto</label>
                            <md-input v-model="noError"></md-input>
                        </md-field>
                        <md-field>
                            <label>Faca um resumo basico do seu projeto</label>
                            <md-textarea v-model="textarea" md-counter="80"></md-textarea>
                        </md-field>

                        <md-autocomplete v-model="selectedEmployee" :md-options="countries" md-dense md-layout="box">
                            <label>Em qual pais o seu projeto esta sendo desenvolvido?</label>
                        </md-autocomplete>
                        <md-checkbox v-model="started" class="md-primary">Seu projeto ja foi iniciado?</md-checkbox>

                        <md-datepicker v-model="selectedDate" md-immediately v-if="!started">
                            <label>Quando pretende iniciar</label>
                        </md-datepicker>

                        <md-datepicker v-model="selectedDate" md-immediately>
                            <label>E quando pretende finalizar</label>
                        </md-datepicker>

                        <md-checkbox v-model="started" class="md-primary">Voce gostariai que pessoas de outros paises vissem seu projeto?</md-checkbox>
                    </md-card-content>
                </md-card>
            </div>
        </md-tab>
        <md-tab id="tab-favorites" md-label="Imagem" md-icon="photo">
            <div class="md-layout md-gutter md-alignment-center-center">
                <md-card class="md-layout-item md-size-50 md-small-size-100">
                    <md-empty-state md-icon="add_a_photo" md-label="Lembre-se, a primeira impressoa e a que fica" md-description="Envie uma foto de perfil do seu projeto que sera usada no cartao do seu projeto.">
                        <md-button class="md-primary md-raised">Escolher imagem</md-button>
                    </md-empty-state>
                </md-card>
            </div>
        </md-tab>
        <md-tab id="tab-finish" md-label="Finalizar" md-icon="done">
            <div class="md-layout md-gutter md-alignment-center-center">
                <md-card class="md-layout-item md-size-50 md-small-size-100">
                    <md-empty-state md-icon="access_time" md-label="Por enquanto e so!" md-description="Para manter nossa plataforma sempre atrativa para as pessoas interessados, cuidamos manualmente de cada projeto publicado com muito carinho. Nosso time de especialista vai analizar a sua proposta e retornaremos em breve">
                    </md-empty-state>
                </md-card>
            </div>
        </md-tab>
    </md-tabs>
</template>
<script>
    export default {
        name: 'AutocompleteStatic',
        data: () => ({
            selectedEmployee: null,
            started: true,
            countries: [
                'Algeria',
                'Argentina',
                'Brazil',
                'Canada',
                'Italy',
                'Japan',
                'United Kingdom',
                'United States'
            ],
        })
    }
</script>

<style lang="scss">
    .adjust-container {
        min-height: 100vh;
        /*height: 100vh;*/
    }
.md-empty-state.md-theme-default .md-empty-state-icon.md-icon-font {
    color: rgba(0, 0, 0, 0);
    color: rgba(0, 0, 0, 0.08);
}
.md-icon.md-theme-default.md-icon-font {
    /* color: rgba(0, 0, 0, 0.35); */
}
.md-empty-state-icon-first > div > .md-empty-state-icon {
     color: var(--md-theme-default-icon-on-background, rgba(0,0,0,0.08))!important; 
    width: 160px;
    position: relative;
    top: 50px;
    min-width: 160px;
    height: 24px;
    font-size: 160px!important;
    margin: 0;
}
</style>