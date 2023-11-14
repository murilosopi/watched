<template>
    <div class="container">
        <div class="content">
                <InteractiveIcon class="fixed-btn" tag="span" title="Escrever">
                    <img class="post-icon" src="/assets/img/icons/post-icon.svg">
                </InteractiveIcon>
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
    align-items:center;
    justify-items: center;
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
    border-top: 10px;
    padding: 10px;
}
.post-icon{
    width: 30px;
    height: 30px;
    z-index: 101;    
}
</style>