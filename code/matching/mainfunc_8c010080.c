extern int njUserExit();
extern int njWaitVSync_8c0571e2();
extern int njUserInit_8c0134ec();
extern int njUserMain_8c01392e();

int mainfunc_8c010080() {
    njUserInit_8c0134ec();

    while (1) {
		if (njUserMain_8c01392e() < 0) break;
		njWaitVSync_8c0571e2();
	}

    return njUserExit();
}
