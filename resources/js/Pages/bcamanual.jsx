import React from "react";
import Subtemplate from "../components/Subtemplate";
import { Link, useForm, usePage } from "@inertiajs/inertia-react";
import { rupiah, tanggal } from "../configapp";

const bcamanual = ({ user, transaksi }) => {
    const { data, setData, post, processing, errors } = useForm({
        jumlah: "",
    });

    const { manual } = usePage().props;
    function handleSubmit(e) {
        e.preventDefault();
        post("/bcamanual", {
            onSuccess: (page) => {
                console.log(page);
            },
        });
    }

    return (
        <>
            <div className="d-flex sub-bg align-items-center justify-content-center">
                <div className="sub-title fs-2">Topup WarungWA</div>
            </div>
            <div className="sub-content bg-white">
                <form onSubmit={handleSubmit}>
                    <div className="card">
                        <div className="card-body">
                            <div className="form-group">
                                <div className="title">Masukan Jumlah </div>
                                <input
                                    type="tel"
                                    className="form-control"
                                    value={data.jumlah}
                                    onChange={(e) =>
                                        setData("jumlah", e.target.value)
                                    }
                                />
                            </div>
                            <input
                                type="submit"
                                className="btn btn-success btn-block mt-2"
                                value="genarete"
                            />
                        </div>
                    </div>
                </form>
                <div className="list-group list-group-light">
                    {manual.map((page, index) => {
                        if (index == 0) {
                            return (
                                <div className="card" key={index}>
                                    <div className="card-body">
                                        {page.status == "PENDING" ? (
                                            <div className="alert alert-danger">
                                                Silahkan Transfer ke rekening
                                                <br />
                                                BCA
                                                <br />
                                                DORIS HERMAWAN
                                                <br />
                                                0231124763
                                                <br />
                                                bayar sesuai dengan jumlah di
                                                bawah
                                                <br />
                                                <div className="card-body bg-warning text-white">
                                                    <b>{rupiah(page.saldo)}</b>
                                                </div>
                                                <br />
                                                <div className="card-body bg-danger text-white">
                                                    {page.status}
                                                    <hr />
                                                    {tanggal(page.created_at)}
                                                </div>
                                                Maksimal pembayaran 12 jam
                                                setelah generate pengajuan TOPUP
                                            </div>
                                        ) : (
                                            ""
                                        )}
                                    </div>
                                </div>
                            );
                        }
                        return (
                            <div key={index}>
                                <Link
                                    href="bcamanual"
                                    className="list-group-item list-group-item-action px-3 border-0 pb-3 "
                                    aria-current="true"
                                >
                                    {page.Trx_ID}
                                    <br />
                                    {page.saldo}
                                    <br />
                                    {page.status}
                                </Link>
                            </div>
                        );
                    })}
                </div>
            </div>
        </>
    );
};
bcamanual.layout = (page) => <Subtemplate children={page} title="topup" />;
export default bcamanual;
