import { useForm, usePage } from "@inertiajs/inertia-react";
import React from "react";
import Subtemplate from "../components/Subtemplate";
import { rupiah } from "../configapp";
import Swal from "sweetalert2";
import { Inertia } from "@inertiajs/inertia";

const gameff = ({ user, transaksi }) => {
    const { flash, auth } = usePage().props;
    const { data, setData, post, processing, errors } = useForm({
        phone: "",
        kode: "",
        type: "Umum",
        category: "Games",
        brand: "FREE FIRE",
    });
    function submit(e) {
        e.preventDefault();
        post("/cektransaksigame", {
            onSuccess: () => {
                // console.log(errors);
            },
            onError: () => {
                // console.log(errors);
            },
        });
    }

    function buttonbeli(kd, ket, hargadasar, price) {
        // console.log(data);
        Swal.fire({
            title: "Apakah Anda Yakin membeli? " + ket,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Beli",
            denyButtonText: `Tidak`,
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.post("/transaksi", {
                    kode: kd,
                    phone: data.phone,
                    hargadasar: hargadasar,
                    price: price,
                });
            } else if (result.isDenied) {
                Swal.fire("Yahh Tidak jadi", "", "info");
            }
        });
    }

    return (
        <>
            <div className="d-flex sub-bg align-items-center justify-content-center">
                <div className="sub-title fs-2">Beli Diamond FREE FIRE</div>
            </div>
            <div className="container sub-content bg-white">
                <div className="card">
                    <form onSubmit={submit}>
                        <div className="card-body">
                            <div className="form-group">
                                <label>
                                    gabungan antara user_id dan zone_id
                                </label>
                                <input
                                    type="tel"
                                    className="form-control"
                                    value={data.phone}
                                    onChange={(e) => {
                                        setData("phone", e.target.value);
                                    }}
                                />
                                {errors.phone && (
                                    <div
                                        id="emailHelp"
                                        className="alert-danger col-12"
                                    >
                                        {errors.phone}
                                    </div>
                                )}
                            </div>
                            <div className="form-group pt-2">
                                <input
                                    type="submit"
                                    value="cek harga"
                                    className="btn btn-block btn-success"
                                />
                            </div>
                        </div>
                        <div className="container">
                            <div className="row">
                                {flash.body &&
                                    flash.body.map((play, index) => {
                                        let hargaakun = 0;
                                        if (auth.user.akun == "member") {
                                            hargaakun = play.member;
                                        }

                                        if (auth.user.akun == "konter") {
                                            hargaakun = play.konter;
                                        }

                                        if (auth.user.akun == "warung") {
                                            hargaakun = play.warung;
                                        }

                                        return (
                                            <div
                                                key={index}
                                                className="col-6 p-1"
                                            >
                                                <div
                                                    className="card"
                                                    onClick={async () => {
                                                        setData(
                                                            "kode",
                                                            play.buyer_sku_code
                                                        );
                                                        buttonbeli(
                                                            play.buyer_sku_code,
                                                            play.desc,
                                                            play.price,
                                                            hargaakun
                                                        );
                                                    }}
                                                >
                                                    <div className="card-body p-1">
                                                        <b>{play.brand}</b>
                                                        <br />
                                                        {play.product_name}
                                                        <div className="alert alert-danger">
                                                            {rupiah(hargaakun)}
                                                        </div>
                                                        {play.desc}
                                                    </div>
                                                </div>
                                            </div>
                                        );
                                    })}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
};

gameff.layout = (page) => <Subtemplate children={page} title="topup" />;
export default gameff;
