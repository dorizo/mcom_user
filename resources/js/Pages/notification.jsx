import { useForm, usePage } from "@inertiajs/inertia-react";
import React, { Component } from "react";
import Subtemplate from "../components/Subtemplate";
import { rupiah } from "../configapp";
import Swal from "sweetalert2";
import { Inertia } from "@inertiajs/inertia";

const notification = ({ user, transaksi }) => {
    return (
        <>
            <div className="d-flex sub-bg align-items-center justify-content-center">
                <div className="sub-title fs-2">Halaman Notification</div>
            </div>
            <div className="container sub-content bg-white">
                <div className="card"></div>
            </div>
        </>
    );
};

notification.layout = (page) => <Subtemplate children={page} title="topup" />;
export default notification;
