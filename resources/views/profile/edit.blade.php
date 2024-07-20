<x-app-layout>
  

<a class="sidebarbuuton a" id="sidebarbuuton" href="#"></a>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            
        </div>
    </div>
</x-app-layout>

<script>
    function cahersidebarre(){
document.querySelector('.sideBarre').classList.add('a1');
console.log('salut')

}
function afficherSidebarre(){
document.querySelector('.sideBarre').classList.remove('a1');
console.log('au revoir')

}

button= document.querySelector('.sidebarbuuton');
button.addEventListener('click',()=>{
afficherSidebarre();
}) 



button1=document.querySelector('.f1');
button1.addEventListener('click',()=>{
cahersidebarre();
}) 


</script>
