var app = (() => {

  function toggleElementVisability(elemId) {
    const elem = document.getElementById(elemId);
    if (!elem) {
      console.error(`elemnt id ${elemId} does not exists.`);
      return;
    }

    if (elem.classList.contains(CLASS_LIST.hide)) {
      elem.classList.remove(CLASS_LIST.hide);
      return;
    }

    elem.classList.add(CLASS_LIST.hide);
  }

  function hideElemnt(elemId) {
    const elem = document.getElementById(elemId);
    elem.classList.add(CLASS_LIST.hide);
  }

  function showElemnt(elemId) {
    const elem = document.getElementById(elemId);
    elem.classList.remove(CLASS_LIST.hide);
  }

  function displaySection(secIdToDisplay, secIdToHide) {
    showElemnt(secIdToDisplay);
    hideElemnt(secIdToHide);
  }

  return {
    toggleElementVisability,
    displaySection
  };
})();
