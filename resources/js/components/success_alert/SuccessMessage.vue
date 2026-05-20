<template>
     <div class="alert alert-success" :success_msg="success_msg">
            <div>
                {{ success_msg }}
            </div>
        </div>
</template>

<script>
export default{
    name:'SuccessMessage',
   props:{
     success_msg:String
   }
}
</script>