import { Link, useForm, usePage } from "@inertiajs/inertia-react";
import React, { Component } from "react";
import Subtemplate from "../components/Subtemplate";
import { rupiah } from "../configapp";
import Swal from "sweetalert2";
import { Inertia } from "@inertiajs/inertia";
import Template from "../components/Template";

const mcom = ({ user, transaksi }) => {
    const { auth } = usePage().props;
    return (
        <>
            <div className="d-flex sub-bg align-items-center justify-content-center"></div>
            <div className="container sub-content bg-white">
                <div className="container">
                    <div className="col-12">
                        <div className="card-1">
                            <div className="card-body">
                                <div className="row">
                                    <div className="d-flex col-5">
                                        <div className="d-flex align-items-center justify-content-center">
                                            <img
                                                src="https://media.licdn.com/dms/image/v2/C5603AQHc0-VDVdCyvA/profile-displayphoto-shrink_400_400/profile-displayphoto-shrink_400_400/0/1642490392445?e=1733356800&v=beta&t=pDFyxs_U1Vi3N13TQIYH69oRLru__idY3cS0xPEsCrs"
                                                alt="Generic placeholder image"
                                                className="rounded-circle borderkartu"
                                                style={{
                                                    width: 100,
                                                    borderRadius: 10,
                                                }}
                                            />
                                        </div>
                                        <div className="flex-grow-1 ms-3">
                                            <div className="sub-title fs-2">
                                                <img
                                                    src="img/mcom.svg"
                                                    width={30}
                                                    className="pt-3"
                                                />
                                            </div>
                                            <div className="mb-1">
                                                {auth.user.name}
                                                <br />
                                                <b>{auth.user.akun}</b>
                                            </div>
                                            <div className="bg2"></div>
                                            <div className="pt-3">
                                                Masa Berlaku
                                                <br />
                                                21 januari 2027
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-12 pt-2">
                    <div className="row">
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/1.svg" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/2.svg" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/3.svg" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/4.svg" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/5.svg" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/6.svg" width="100%" />
                            </Link>
                        </div>

                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/7.svg" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/8.svg" width="100%" />
                            </Link>
                        </div>
                        <div className="col-4 pt-2">
                            <Link className="card">
                                <img src="img/icon/9.svg" width="100%" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

mcom.layout = (page) => <Template children={page} title="topup" />;
export default mcom;
