<template>
  <div class="page-header">
    <div class="left">
      <div class="btn faq">FAQs</div>
      <div class="btn">login</div>
    </div>
    <div class="middle">
      <div class="page-name">cdu side gigs</div>
      <div class="page-description">Where students and staff work side by side  </div>
    </div>
    <div class="right">
      <div class="btn">create a student profile</div>
      <div class="btn">create a staff profile</div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.page-header {
  padding: 16px;
  height: 200px;
  background-color: var(--base-white);
  position: relative;
  .btn {
    background-color: #ff5757;
    color: var(--base-white);
    padding: 0px 8px;
    border-radius: 4px;
    &.faq {
      background-color: #ffed00;
      color: var(--base-black);
    }
  }

  .left,
  .right {
    position: absolute;
    display: flex;
    column-gap: 10px;
    align-items: flex-start;
    top: 16px;
  }

  .left {
    left: 16px;
  }

  .right {
    right: 16px;
  }

  .middle {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    .page-name {
      font-size: 60px;
      font-weight: 900;
      text-transform: uppercase;
      text-shadow: 2px 2px var(--gray);
    }
    .page-description {
      font-size: 24px;
      text-shadow: 0.5px 1px var(--gray);
      margin-top: -14px;
    }
  }
}
</style>
