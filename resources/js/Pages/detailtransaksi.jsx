import React from "react";
import Subtemplate from "../components/Subtemplate";
import { rupiah } from "../configapp";

const detailtransaksi = ({ detail }) => {
    return (
        <div className="container">
            <div className="fs-1 d-flex justify-content-center">
                TRANSAKSI DETAIL
            </div>
            <b className="fs-6 d-flex justify-content-center">
                No Invoice
                <br /> {detail.trx_id}
            </b>
            <div className="col-12 alert alert-primary">
                pembelian {detail.category} {detail.desc} dengan harga{" "}
                {rupiah(detail.price)}
            </div>
            Dengan Status :
        </div>
    );
};

detailtransaksi.layout = (page) => (
    <Subtemplate children={page} title="topup" />
);
export default detailtransaksi;
