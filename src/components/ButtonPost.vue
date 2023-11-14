<template>
    <div class="container">
        <div class="content">
            <button type="button" class="fixed-btn" >
                <InteractiveIcon tag="span" title="Escrever">
                    <img class="post-icon" src="/assets/img/icons/post-icon.svg">
                </InteractiveIcon>
            </button>
        </div>
    </div>
</template>
<script>
import InteractiveIcon from './InteractiveIcon.vue';

export default {
    components: {
        InteractiveIcon
    }

}
</script>
<style scoped>
.container {
    position:sticky;
    z-index: 100;
}
.content {
    position:absolute;
    align-items:center
}
.fixed-btn {
    cursor:pointer;
    position:fixed;
    background:#fff;
    width: 50px;
    height: 50px;
    border-radius:50%;
    bottom: 35px;
    right: 35px;
    border-width: 1px;
}
.post-icon{
    width: 25px;
    height: 25px;
    z-index: 101;
}
</style>