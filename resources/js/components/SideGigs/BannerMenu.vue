<script>
export default {
  data() {
    return {
      menus: [
        {
          title: "Computing and IT",
          itemLinks: [
            {
              id: 1,
              path: '#',
              label: 'Database'
            },
            {
              id: 2,
              path: '#',
              label: 'Software and programming'
            },
            {
              id: 3,
              path: '#',
              label: 'SharePoint'
            },
            {
              id: 1,
              path: '#',
              label: 'Web, Mobile, App development'
            },
          ],
        },
        {
          title: "Data and Analytics",
          itemLinks: [
            {
              id: 1,
              path: '#',
              label: 'Statistical analysis'
            },
            {
              id: 2,
              path: '#',
              label: 'Data entry'
            },
            {
              id: 3,
              path: '#',
              label: 'Data management'
            },{
              id: 4,
              path: '#',
              label: 'Data processing, preparation and cleaning'
            }
          ],
        },
        {
          title: "Media and Design",
          itemLinks: [
            {
              id: 1,
              path: '#',
              label: 'Animation'
            },
            {
              id: 2,
              path: '#',
              label: 'Graphic design'
            },
            {
              id: 3,
              path: '#',
              label: 'Web, Mobile, App development',
            },
            {
              id: 4,
              path: '#',
              label: 'Photography',
            },
            {
              id: 5,
              path: '#',
              label: 'Videography',
            }
          ]
        },
        {
          title: "Maketing and Comms",
          itemLinks: [
            {
              id: 1,
              path: '#',
              label: 'Content and copywriting'
            },
            {
              id: 2,
              path: '#',
              label: 'Scocial media'
            }
          ]
        }
      ]
    };
  },
}
</script>

<template>
  <div class="menu">
    <div class="col-4 menu-item" v-for="(menu, i) in menus" :key="i"> 
      <h2>{{ menu.title }}</h2>
      <div class="item-links">
        <a v-for="item in menu.itemLinks" :key="item.id" :href="item.path">
          {{ item.label }}
        </a>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.menu {
  display: flex;
  background: var(--base-black);
  column-gap: 12px;
  width: 100%;
  padding: 16px;
  .col-4 {
    width: 25%;
  }
  .menu-item {
    padding: 16px;
    background: var(--red-transparent);
    color: var(--base-white);
    display: flex;
    flex-direction: column;
    border-radius: 4px;

    > h2 {
      font-weight: 700;
    }
    .item-links {
      display: flex;
      flex-direction: column;
      > a {
        &:active, &:visited {
          color: inherit;
        }
        color: var(--white);
        font-size: 14px;
        text-decoration: none;

        &:hover {
          text-decoration: underline;
        }

        &::after {
          content: " →";
        }
      }
    }
  }
}
</style>
