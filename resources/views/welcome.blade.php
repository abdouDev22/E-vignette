<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    @vite(['resources/scss/style.scss','resources/js/app.js'])
</head>
<body>
    <div class="content1">
        <a class="sidebarbuuton a" href="#"></a>
        <h1>Choisir la voiture</h1>
        <div class="grid">
          @foreach ($voitures as $voiture )
            <div class="item">
              <a href="vigetteObetnu" class="lien">
                <div class="item-content">
                  <span class="no">No :</span>
                  <span class="no1">{{$voiture->matricule}}</span>
                  <span class="nb">Nb :</span>
                  <span class="nb1">{{$voiture->chevaux}}</span>
                  </div>
              </a>
              </div>  
              @endforeach

        </div>
    </div>
  <div class="sideBarre a1">
  <div class="f1"><svg  width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"/><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/><g id="SVGRepo_iconCarrier"> <path d="M10.0303 8.96965C9.73741 8.67676 9.26253 8.67676 8.96964 8.96965C8.67675 9.26255 8.67675 9.73742 8.96964 10.0303L10.9393 12L8.96966 13.9697C8.67677 14.2625 8.67677 14.7374 8.96966 15.0303C9.26255 15.3232 9.73743 15.3232 10.0303 15.0303L12 13.0607L13.9696 15.0303C14.2625 15.3232 14.7374 15.3232 15.0303 15.0303C15.3232 14.7374 15.3232 14.2625 15.0303 13.9696L13.0606 12L15.0303 10.0303C15.3232 9.73744 15.3232 9.26257 15.0303 8.96968C14.7374 8.67678 14.2625 8.67678 13.9696 8.96968L12 10.9393L10.0303 8.96965Z" fill="#1C274C"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.25C6.06294 1.25 1.25 6.06294 1.25 12C1.25 17.9371 6.06294 22.75 12 22.75C17.9371 22.75 22.75 17.9371 22.75 12C22.75 6.06294 17.9371 1.25 12 1.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75C17.1086 2.75 21.25 6.89137 21.25 12C21.25 17.1086 17.1086 21.25 12 21.25C6.89137 21.25 2.75 17.1086 2.75 12Z" fill="#1C274C"/> </g></svg></div>
      <div class="contenu">
          
          <a href="#" class="abou">Deconnexion</a>
          <a href="/" class="abou active">Acceuille</a>
          <a href="profile" class="abou">Profile</a>
          <a href="achatVignette" class="abou">Achat de vignette</a>
      </div>


    <script src="https://cdn.jsdelivr.net/npm/muuri@0.9.5/dist/muuri.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/web-animations-js@2.3.2/web-animations.min.js"></script>

    <script>
        var grid = new Muuri('.grid', {
  dragEnabled: false,
  dragHandle: '.item-content', 
  layout: {
    fillGaps: false,
    horizontal: false,
  },
  layoutDuration: 500
});
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

</body>
</html>