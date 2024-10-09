<template>
  <form class="flex flex-col items-center w-1/2 mt-4 space-y-8">
    <div class="group-input">
      <label for="email">email: </label>
      <div>
        <i class="fa-solid fa-user" />
        <input class="input-field" placeholder="Type your email" name="email" type="email" />
      </div>
    </div>

    <div class="group-input">
      <label for="password">password: </label>
      <div>
        <i class="fa-solid fa-lock" />
        <input
          class="input-field"
          placeholder="Type your password"
          name="password"
          type="password"
        />
      </div>
    </div>

    <div class="self-end">
      <button><p>forgot password ?</p></button>
    </div>

    <button
      class="w-4/5 py-2 font-bold text-white uppercase border-none bg-primary-color hover:bg-hover-primary-color hover:text-slate-800 rounded-3xl"
    >
      login
    </button>

    <div class="text-center">
      <p>or login using...</p>
      <div class="flex justify-center gap-4 py-2">
        <div class="bg-blue-700 icon-button"><i class="fa-brands fa-facebook-f"></i></div>
        <div class="bg-red-500 icon-button"><i class="fa-solid fa-g"></i></div>
        <div class="bg-black icon-button"><i class="fa-brands fa-github"></i></div>
      </div>
    </div>

    <div>
      <p>if have no account...</p>
      <router-link :to="{ name: 'signup' }">
        <p class="mt-2 font-bold text-center uppercase">sign up</p>
      </router-link>
    </div>
  </form>
</template>

<style scoped>
p {
  @apply text-xs italic;
}

.group-input {
  @apply border-b-2 flex flex-col w-4/5;
}

.input-field {
  @apply p-2 outline-none;
}

.icon-button {
  @apply border-none rounded-full p-2 w-10 text-center text-white font-bold cursor-pointer;
}

.group-input i {
  @apply hidden lg:inline-block;
}
</style>
