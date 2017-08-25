<template>
    <img class='icon' :src="imgsrc" v-if="type == 1">
    <Icon :type="icon" v-else class="icon"></Icon>
</template>
<script>
export default{
    name:'navicon',
    props:['icon','type'],
    computed:{
        imgsrc:function(){
            return "/images/navicon/"+this.icon
        }
    }
}
</script>