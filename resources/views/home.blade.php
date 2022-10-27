@extends('layouts.master')

@section('main')
  <div class="bg-blue-700 text-white px-2">Test submission by John Lioneil Dionisio</div>

  <h1 class="text-4xl font-bold mt-10 mb-6">Tiny URL</h1>
  <div class="mt-4">
    <app-search-field placeholder="Search a URL"></app-search-field>
    <div class="p-4 mb-4 text-sm text-blue-400 bg-blue-100 rounded-lg dark:bg-blue-100 dark:text-blue-800" role="alert">
      <span class="font-medium">Tip:</span> Search with double quotes for case-sensitive queries, E.g. "tinyurl.com/1a7a6907", with the quotes to retrieve exact matches.
    </div>
  </div>
  <app-list-items
    :api="{
      list: '/api/v1/destinations',
    }"
  >
    <template v-slot:item="{ item, index }">
      <h1 class="text-2xl font-bold" v-text="item.alias"></h1>
      <span class="text-blue-800" v-text="item.url"></span>
      {{-- <span class="px-4 text-green-500" v-text="item.status"></span> --}}
    </template>
  </app-list-items>
@endsection
