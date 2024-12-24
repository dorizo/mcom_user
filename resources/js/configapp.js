export function tanggal(dateString) {
    const options = { year: "numeric", month: "long", day: "numeric" };
    let ssss = new Date(dateString).toLocaleTimeString();
    let tanggal = new Date(dateString).toLocaleDateString();
    return tanggal + " " + ssss;
}
export function rupiah(rupiah) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(rupiah);
}
