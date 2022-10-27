import queryString from 'query-string';

const $params = queryString.parse(window.location.search);

const items = {
  items: [],
  pagination: {
    // @ts-ignore
    page: parseInt($params.page ?? 1, 10),
    perPage: $params.per_page ?? 15,
  },
  params: {
    q: null,
    page: 1,
    per_page: 15,
    ...$params,
  },
  count () {
    return this.items.length;
  },
  total () {
    return this.pagination.total;
  },
  setItems (items) {
    this.items = items;
  },
  addItems (items) {
    this.items = this.items.concat(items);
  },
  setSearch (query) {
    this.params.q = query;
    this.updateURLParams();
  },
  getParamsAsString () {
    return queryString.stringify(this.params);
  },
  updateURLParams () {
    window.history.replaceState(null, '', `?${this.getParamsAsString()}`);
  },
  setPagination (pagination) {
    this.pagination = {
      ...this.pagination,
      page: pagination.current_page,
      pageCount: pagination.last_page,
      perPage: pagination.per_page,
      total: pagination.total,
    };
  },
  isLastPage () {
    return this.pagination.page >= this.pagination.pageCount;
  },
  incrementPage () {
    this.pagination.page += 1;
  },
};

export function defineItems (attributes = {}) {
  return {
    ...items,
    ...attributes,
  };
}
