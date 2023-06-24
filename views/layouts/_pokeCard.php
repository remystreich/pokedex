<?php
echo'
<div class="mb-6 lg:mb-0">
  <div class="block rounded-lg bg-opacity-50 bg-light-200 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] ">
    <div class="relative overflow-hidden bg-cover bg-no-repeat">
      <img src=".'.$pokemon['image'].'" class="w-full rounded-t-lg" />
      <svg class="absolute text-white  left-0 bottom-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="green" d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,250.7C1248,256,1344,288,1392,304L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
        </path>
      </svg>
    </div>
    <div class="p-6">
      <h5 class="mb-4 text-lg font-bold">'.$pokemon['name'].'</h5>
      <p class="mb-4  ">'.$pokemon['type'].'</p>
      <ul class="mx-auto flex list-inside justify-center">
        <li>
          <a href="/pokedex/index.php/updatePoke/'.$pokemon['id'].'" class="px-2">
            <i class="fa-solid fa-pen fa-xl" style="color: #2527eb;" title="Modifier"></i>
          </a>
        </li>
        <li>
          <a href="/pokedex/index.php/dashboard/deletePoke/'.$pokemon['id'].'/'.$pokemon['image'].'" class="px-2">
            <i class="fa-solid fa-trash fa-xl" style="color: #b81919;" title="Supprimer"></i>
          </a>
        </li>
        <li>
          <a href="/pokedex/index.php/evoPoke/'.$pokemon['id'].'" class="px-2">
          <i class="fa-solid fa-dna fa-xl "  title="Faire évoluer"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
'?>