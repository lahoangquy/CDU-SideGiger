<script>
import BannerMenu from "./BannerMenu.vue";
import TermNCond from "./TermNCond.vue";
import GigsItem from "./GigsItem.vue";
import GigsButton from "./GigsButton.vue";
import GigsStep from "./GigsStep.vue";

export default {
  components: { BannerMenu, TermNCond, GigsItem, GigsButton, GigsStep },
  data() {
    return {
      staffGigsSteps: [
        {
          icon: 'user-circle',
          text: 'Identify a discrete task  requiring no more than 50 hours work*'
        },
        {
          icon: 'search',
          text: 'Ensure you have clear outcomes and expectations '
        },
        {
          icon: 'open-email',
          text: 'Post your gig'
        },
        {
          icon: 'user-circle',
          text: 'Review applications and select  student '
        },
        {
          icon: 'user-circle',
          text: 'Cleary communicate expectations and negotiate requirements'
        },
        {
          icon: 'user-circle',
          text: 'Support student to complete the task'
        }
      ],
      studentGigsSteps: [
        {
          icon: 'user-circle',
          text: 'Create your profile'
        },
        {
          icon: 'search',
          text: 'Browse and apply for gigs'
        },
        {
          icon: 'open-email',
          text: 'You will be notified if you win the gig'
        },
        {
          icon: 'user-circle',
          text: 'Understand project requirement'
        },
        {
          icon: 'user-circle',
          text: 'Completed and submit work'
        },
      ],

    };
  },
};
</script>

<template>
  <div class="side-gigs">
    <div class="banner">
      <div class="wrapper">
        <div class="description">
          Welcome to CDU Side Gigs, the place where students with the following skills can work on a project that benefits the CDU community.
        </div>
        <BannerMenu />
      </div>
    </div>
    <div class="gigs-items">
      <GigsItem title="students">
        <div class="gis-item-wrapper">
          <div class="text-strong">Do you want to:</div>
          <div class="text-strong">Hone your skills?</div>
          <div class="text-strong">Boost your confidence?</div>
          <duv class="text-strong">Increase your employability?</duv>
          <p>
            Get ready to thrive in the gig economy by volunteering up to 50
            hours of your talents on mini projects or "gigs" that benefit the
            CDU community. Many gigs are online, so you can work on them
            whenever and wherever it suits you.
          </p>
        </div>
      </GigsItem>
      <GigsItem isStaff title="STAFf">
        <div class="gis-item-wrapper">
          <div class="text-strong">Do you:</div>
          <div class="text-strong">Have an idea for a CDU project?</div>
          <div class="text-strong">Need 50 hours of resource?</div>
          <div class="text-strong">Want to develop the employability of a student?</div>
          <p>
            Our talented students are looking for experience.
            Post a mini project or "gig" of no more than 50 hours and let a
            student volunteer to help you get things done!
          </p>
        </div>
      </GigsItem>
    </div>
    <div class="gigs-items" style="margin-top: 12px">
      <GigsItem title="how it works for students">
        <div class="gis-item-wrapper">
          <GigsStep steps="studentGigsSteps" />
          <div class="gigs-guidline">
            <GigsButton>Browse gigs</GigsButton>
          </div>
        </div>
      </GigsItem>
      <GigsItem isStaff title="how it works for staff">
        <div class="gis-item-wrapper">
          <GigsStep steps="staffGigsSteps" />
          <div class="gigs-guidline">
            <GigsButton isStaff>Post a gig</GigsButton>
          </div>
        </div>
      </GigsItem>
    </div>
    <TermNCond />
  </div>
</template>

<style lang="scss" scoped>
.side-gigs {
  --red: #a71930;
  --pearl: #a0cfeb;
  --yellow: #efbd47;
  --gray: #7c7c7d;
  --light-gray: #f3f4f6;
  --base-white: #fff;
  --base-black: #000;
  --red-transparent: #90514a;

  display: flex;
  flex-direction: column;
  .warpper {
    width: 1200px;
    margin: auto;
  }
  .banner {
    background: var(--red);
    color: var(--base-white);
    display: flex;
    flex-direction: column;
    padding: 16px 0px;
    .wrapper {
      width: 1200px;
      margin: auto;
      .description {
        padding: 16px;
      }
    }
  }

  .gigs-items {
    display: flex;

    > div {
      flex-shrink: 0;
      width: 50%;
    }

    .gis-item-wrapper {
      display: flex;
      flex-direction: column;

      .text-strong {
        font-weight: bold;
        font-size: 24px;
      }
    }

    .gigs-guidline {
      display: flex;
      justify-content: center;
    }
  }
}
</style>
