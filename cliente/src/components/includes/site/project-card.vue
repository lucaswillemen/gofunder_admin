<template>
<div class="projects">
  <b-card  @click="openTab(project.id, project.title)" style="cursor:pointer;" v-for="(project, index) in projects" :key="index" :title="project.title" img-src="https://via.placeholder.com/150" :img-alt="Image" img-top tag="article" class="mb-4">
    <div class="bottom-img">
      <span class="center-obj-v">{{project.category_name}}</span>
      <font-awesome-icon :icon="['far', 'heart']"></font-awesome-icon>
    </div>
    <div class="line" :class="getClassTopLine(project.tipo)">
      <span class="center-obj-v">{{project.tipo}}</span>
    </div>
    <div class="line-bottom">
      <span :class="getClassBottomLine(project.tipo)">
        {{project.lancamento}}
      </span>
    </div>
    <p class="card-text">
      {{project.description}}
    </p>
    <div class="bottomBar" v-if="project.tipo == 'Funding'">
      <p class="total">Total Arrecadado {{project.cash_received  | currency}} </p>
      <progress-bar :max="100" :current="project.percent"></progress-bar>
      <p class="meta">Meta {{project.cash | currency}}</p>
    </div>
    <div v-else>
      <!--
      <p class="liquid">{{project.liquid}} <span class="value">{{project.value}}</span> <span class="discount">{{project.discount}}</span></p>
      !-->
    </div>
  </b-card>
</div>
</template>

<script>
export default {
  props: ['projects'],
  methods: {
    openTab(id, title) {
      window.location.replace("/#/project-info/" + id+ "/"+title)
      return window.location.reload(true)
    },
    getClassTopLine(type) {
      return (type == 'Funding' ? 'bgorange' : 'bgblue')
    },
    getClassBottomLine(type) {
      return (type == 'Funding' ? 'fColorOrange' : 'fColorBlue')
    }
  }
}
</script>

<style lang="scss">
@import "Styles/colors.scss";

.projects {

    .card {
        .bottomBar {
            bottom: 40px;
            position: absolute;
            width: 80%;
        }
        max-width: 14rem;
        margin: 0 20px;
        float: left;
        color: #707070;

        &:before {
            content: '';
            position: absolute;
            top: 110px;
            right: 0;
            left: 0;
            background-image: -webkit-gradient(linear, left bottom, left top, from(black), to(#ffffff00));
            background-image: linear-gradient(to top, black, #ffffff00);
            opacity: 0.8;
            z-index: 1;
            max-height: 90px;
            height: 100%;
        }
        .card-img-top {
            position: relative;
            max-width: 100%;
            max-height: 200px;
            height: 100%;
        }
        .card-body {
            background-color: #f0f0f0;
            padding-top: 50px;
            padding-bottom: 50px;
            position: relative;
            height: 100%;
            max-height: 300px;

            .bottom-img {
                position: absolute;
                top: -27px;
                left: 13px;
                font-weight: 600;
                font-size: 12px;
                width: 100%;

                svg {
                    right: 31px;
                    position: absolute;
                    bottom: -14px;
                    font-size: 18px;
                    cursor: pointer;
                }

                span,
                svg {
                    color: #ffffff75;
                    z-index: 99;
                }

                svg:hover > path {
                    color: $orange;
                }
            }

            .line {
                position: absolute;
                height: 30px;
                width: 100%;
                top: 0;
                left: 0;

                span {
                    color: white;
                    height: 21px;
                    font-weight: 400;
                    padding-left: 10px;
                    font-size: 15px;
                }
            }

            .bgorange {
                background-color: $orange;
            }
            .bgblue {
                background-color: $blue;
            }

            .line-bottom {
                position: absolute;
                height: 30px;
                width: 100%;
                bottom: 0;
                left: 0;
                text-align: center;
                background-color: #e2e2e2;
                padding-top: 6px;

                span {
                    font-size: 13px;
                    font-weight: 600;
                }

                .fColorOrange {
                    color: $orange;
                }
                .fColorBlue {
                    color: $blue;
                }
            }

            .card-title {
                font-size: 15px;
            }

            .card-text {
                font-size: 12px;
                line-height: 13px;
            }

            .meta,
            .total {
                font-size: 11px;
                font-weight: 600;
                margin-bottom: 2px;
            }

            .total {
                color: $orange;
            }
            .meta {
                color: $blue;
            }

            .liquid {
                color: $blue;
                font-weight: 500;
                margin-bottom: 18px;
                margin-top: 32px;
                font-size: 14px;

                .discount,
                .value {
                    color: #6f6f6f;
                    font-weight: 400;
                }

            }

        }

    }

}
</style>
