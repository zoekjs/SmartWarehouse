export function numberValidator(element) {
    const reg = new RegExp(/^\d+$/);
    return element === "" ? "" : reg.test(element);
}
