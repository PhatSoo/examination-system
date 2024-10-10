<template>
  <form class="flex flex-col items-center w-4/5 max-w-3xl mt-4 space-y-8 md:1/3">
    <div class="group-input">
      <label for="email">email:</label>
      <div>
        <i class="fa-solid fa-user" />
        <input class="input-field" placeholder="Type your email" name="email" type="email" />
      </div>
    </div>

    <div class="group-input">
      <label for="name">display name:</label>
      <div>
        <i class="fa-solid fa-signature" />
        <input class="input-field" placeholder="Type your email" name="name" type="text" />
      </div>
    </div>

    <div class="group-input">
      <label for="password">password:</label>
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

    <div class="group-input">
      <label for="password_confirmation">password:</label>
      <div>
        <i class="fa-solid fa-unlock-keyhole" />
        <input
          class="input-field"
          placeholder="Type your password"
          name="password_confirmation"
          type="password"
        />
      </div>
    </div>

    <button
      class="w-4/5 py-2 font-bold text-white uppercase border-none bg-primary-color hover:bg-hover-primary-color hover:text-slate-800 rounded-3xl"
    >
      signup
    </button>

    <div>
      <p>if have an account...</p>
      <router-link :to="{ name: 'login' }">
        <p class="mt-2 font-bold text-center uppercase">login</p>
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
