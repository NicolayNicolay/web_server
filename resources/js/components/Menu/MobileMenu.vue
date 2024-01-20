<template>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header py-4">
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mt-2">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item w-100" v-for="(item, index) in items" :key="index">
          <a :href="item.url" class="nav-link w-100" :class="item.active ? 'active': ''">{{ item.name }}</a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  items: {
    type: Array,
    default: [],
  }
});

function showMenuItem(el: any) {
  el.parentNode.parentNode.parentNode.classList.toggle('open')
}
</script>

<style scoped lang="scss">
.offcanvas {
  a {
    text-shadow: none;
  }

  h6 {
    font-size: 1.875rem;
    line-height: 2.25rem;
  }

  .offcanvas-body {
    padding: 0 1.3125rem;

    .border-top {
      margin-top: 1.3125rem;
      border-top: 1px solid #60C3D0 !important;
    }

    .open {
      h6 {
        color: #007395 !important;
      }

      .items {
        display: block !important;
      }

      .btn-icon {
        img {
          transform: rotate(180deg);
          -ms-transform: rotate(180deg);
          -webkit-transform: rotate(180deg);
        }
      }
    }

    .item {
      border: none;
      margin-bottom: 0.75rem;

      .btn-icon {
        img {
          -webkit-transition: -webkit-transform .2s ease-in-out;
          -ms-transition: -ms-transform .2s ease-in-out;
          transition: transform .2s ease-in-out;
        }
      }

      .items {
        padding: 0;
        display: none;

        ul {
          list-style: none;
          margin: 0;
          padding: 0;
          display: flex;
          flex-direction: column;

          li {
            margin-top: 1rem;
            text-align: left;

            a {
              color: #007395;
              font-size: 1.5rem;
            }
          }
        }
      }

      //.accordion-button::after {
      //  width: 1.25rem;
      //  height: 0.75rem;
      //  --bs-accordion-btn-icon: url(/images/svg/chevron-down-menu.svg);
      //  --bs-accordion-btn-active-icon: url(/images/svg/chevron-down-menu.svg);
      //}

      .accordion-button:focus {
        box-shadow: none;
      }

      .accordion-button:not(.collapsed) {
        box-shadow: none;

        h6 {
          color: #5F6678;
        }
      }

      .accordion-button {
        padding: 0;
        background: white;
      }
    }
  }

  .btn-close {
    //--bs-btn-close-bg: url(/images/svg/cross.svg);
    --bs-btn-close-opacity: 1;
  }

  .offcanvas-header {
    justify-content: flex-end;
    --bs-offcanvas-padding-y: 3rem;
    --bs-offcanvas-padding-x: 1.3125rem;
  }

  .phone-block {
    margin-top: 1.6875rem;

    a {
      font-size: 1.75rem;
      color: #60C3D0;
      letter-spacing: 3px;
    }

    svg {
      g {
        stroke: #60C3D0;
      }
    }
  }

  .wts-btn {
    margin-top: 1.25rem;
  }
}
</style>
